all: default

mm=/s1/james/projects/zap/sources/tools/config/MakeMenus
mmopts=-DAllowDefaults -DEmail -DNewFonts -DWindowSaveDefaults -DConfigureSourceMenus -DHelpLauncherMenu

default: default/Config/Menus/UK,fff default/Config/Menus/France,fff default/Config/Menus/Germany,fff

default/Config/Menus/UK,fff: default/Config/Menus/Source/UK,fff
	${mm} ${mmopts} $< $@

default/Config/Menus/France,fff: default/Config/Menus/Source/France,fff
	${mm} ${mmopts} $< $@

default/Config/Menus/Germany,fff: default/Config/Menus/Source/Germany,fff
	${mm} ${mmopts} $< $@
