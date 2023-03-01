<?php
# This file was automatically generated by the MediaWiki 1.27.1
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings

$wgShowExceptionDetails = true;

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename = "dan.wiki";
$wgMetaNamespace = "Project";

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "";

## The protocol and server name to use in fully-qualified URLs
#$wgServer = "https://danwiki.herokuapp.com";
$wgServer = "http://www.dan.wiki";
#$wgServer = "dan.wiki";

## The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;

## The URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogo = "https://danwiki.herokuapp.com/logo.png";

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "apache@danwiki.herokuapp.com";
$wgPasswordSender = "apache@danwiki.herokuapp.com";

$wgEnotifUserTalk = true; # UPO
$wgEnotifWatchlist = true; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = "postgres";
$wgDBserver = getenv("wgDBserver");
$wgDBname = getenv("wgDBname");
$wgDBuser = getenv("wgDBuser");
$wgDBpassword = getenv("wgDBpassword");

# Postgres specific settings
$wgDBport = getenv("wgDBport");
$wgDBmwschema = "mediawiki";

## Shared memory settings
$wgMainCacheType = CACHE_NONE;
$wgMemCachedServers = [];

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = true;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "en_US.utf8";

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publically accessible from the web.
#$wgCacheDirectory = "$IP/cache";

# Site language code, should be one of the list in ./languages/data/Names.php
$wgLanguageCode = "en";

$wgSecretKey = getenv("wgSecretKey");

# Changing this will log out all existing sessions.
$wgAuthenticationTokenVersion = "1";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = getenv("wgUpgradeKey");

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "https://www.gnu.org/copyleft/fdl.html";
$wgRightsText = "GNU Free Documentation License 1.3 or later";
$wgRightsIcon = "$wgResourceBasePath/resources/assets/licenses/gnu-fdl.png";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

# The following permissions were set based on your choice in the installer
$wgGroupPermissions['*']['createaccount'] = false;
$wgGroupPermissions['*']['edit'] = false;

# Prevent new user registrations except by sysops
$wgGroupPermissions['*']['createaccount'] = false;

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

# Enabled skins.
# The following skins were automatically enabled:
wfLoadSkin( 'CologneBlue' );
wfLoadSkin( 'Modern' );
wfLoadSkin( 'MonoBook' );
wfLoadSkin( 'Vector' );


# Enabled extensions. Most of the extensions are enabled by adding
# wfLoadExtensions('ExtensionName');
# to LocalSettings.php. Check specific extension documentation for more details.
# The following extensions were automatically enabled:
require_once "$IP/extensions/PrivatePageProtection/PrivatePageProtection.php";


# End of automatically generated settings.
# Add more configuration options below.

require_once "$IP/extensions/googleAnalytics/googleAnalytics.php";

// Replace xxxxxxx-x with YOUR GoogleAnalytics UA number

$wgGoogleAnalyticsAccount = $GLOBALS["wgGoogleAnalyticsAccount"];

// Optional Variables (both default to true)

$wgGoogleAnalyticsIgnoreSysops = false;

$wgGoogleAnalyticsIgnoreBots = false;

// If you use AdSense as well and have linked your accounts, set this to true to enable tracking

$wgGoogleAnalyticsAddASAC = false;

require_once("$IP/extensions/Sort2.php");
$wgExpensiveParserFunctionLimit = 10000;
