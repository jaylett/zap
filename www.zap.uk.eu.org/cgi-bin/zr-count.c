#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <errno.h>
#include <limits.h>
#include <fcntl.h>
#include <unistd.h>
#include <sys/stat.h>

#define VOTE_FILE "../.count/zapredraw.count"
#define VERSIONS 5


static char lockfile[4096] = "";
unsigned int havelock = 0;


static void fail (const char *msg) __attribute__ ((noreturn));

static void
fail (const char *msg)
{
  printf ("\
Content-Type: text/plain\n\
\n\
ZapRedraw counter script error (%s): %s.\n%s", msg + (*msg == '#'),
    strerror (errno), (*msg == '#') ? "" : "Report this to the webmaster.\n");
  exit (0);
}


static void
put_moved (const char *suffix)
{
  char *server = getenv ("SERVER_NAME");
  char *port = getenv ("SERVER_PORT");
  char *uri = getenv ("REQUEST_URI");
  char *p = strstr (uri, "/cgi-bin/");

  if (!p)
    p = uri;
  *p = 0;
  if (!strcmp (port, "80"))
    port = 0;

  printf ("\
Location: http://%s%s%s/%sredraw/%s\n\n", server, port ? ":" : "", port ? port : "", uri, suffix);
}


static void
rmlock (void)
{
  if (havelock)
    unlink (lockfile);
  if (havelock > 1)
    unlink (VOTE_FILE".lock");
}


int
main (void)
{
  char *string;
  int content_length = 0;

  string = getenv ("SCRIPT_FILENAME");
  if (!string)
  {
    errno = ENODATA;
    fail ("can't chdir");
  }
  *strrchr (string, '/') = '\0';
  if (chdir (string))
    fail ("can't chdir");

  atexit (rmlock);

  string = getenv ("CONTENT_LENGTH");
  if (string)
  {
    content_length = atoi (string);
    if (content_length > 0)
    {
      if (content_length > 256)
	content_length = 256;
      string = malloc (content_length);
      if (!string
	  || fread (string, 1, content_length, stdin) < content_length)
	fail ("couldn't read POST data");
    }
    else
      string = 0;
  }
  if (!string)
    string = getenv ("QUERY_STRING");

  if (string)
  {
    unsigned long int vote_number = -1;
    int viewfinder = 0;
    char *p = string - 1;
    unsigned int version[VERSIONS] = { 0 }, ver_vf[VERSIONS - 2] = { 0 };

    while (p && *++p)
    {
      if (!strncmp (p, "Version=", 8))
	vote_number = strtoul (p + 8, &p, 10) & 0xFF;
      else if (!strncmp (p, "Viewfinder", 10))
	viewfinder = 1;
      p = strchr (p, '&');
    }

    if (vote_number < VERSIONS)
    {
      int file;
      FILE *fd;
      int timer = 20;
      struct stat check;

      sprintf (lockfile, "%s.%s.%i", VOTE_FILE, getenv ("SERVER_NAME"),
	       getpid ());

      /* Make the lockfile */
      file = creat (lockfile, 0600);
      if (file == -1)
	fail ("couldn't lock");
      havelock = 1;
      /* Link to it */
      while (link (lockfile, VOTE_FILE".lock"))
      {
	if (errno != EEXIST)
	  fail ("couldn't lock");
	if (!fstat (file, &check) && check.st_nlink == 2)
	  break;
	sleep (1);
	if (--timer == 0)
	  fail ("couldn't lock");
      }
      havelock = 2;
      /* We have a lock */
      close (file);
      /* Open the count file */
      fd = fopen (VOTE_FILE, "r+");
      if (fd)
      {
	/* Read it */
	/* FIXME: use strtol */
	if (fscanf (fd, "%i %i %i %i %i\n %i %i %i",
		    &version[0], &version[1], &version[2], &version[3], &version[4],
		    &ver_vf[0], &ver_vf[1], &ver_vf[2]) < 0
	    && !feof (fd))
	  fail ("couldn't read counters file");
      }
      else
      {
	/* Not there - open for write only */
	fd = fopen (VOTE_FILE, "w");
	if (!fd)
	  fail ("couldn't open counters file");
      }
      /* Increment */
      version[vote_number]++;
      if (viewfinder && vote_number > 1)
	ver_vf[vote_number - 2]++;
      /* Write */
      /* FIXME: use lots of fprintfs */
      if (fseek (fd, 0, SEEK_SET) ||
	  fprintf (fd, "%i %i %i %i %i\n %i %i %i",
		   version[0], version[1], version[2], version[3], version[4],
		   ver_vf[0], ver_vf[1], ver_vf[2]) < 0)
	fail ("couldn't write counters file!!!");
      /* Close */
      if (fclose (fd))
	fail ("couldn't close counters file!!!");
      put_moved ("stat/y");
    }
    else
      put_moved ("stat/n");
  }
  else
    put_moved ("stat/n");
  return 0;
}
