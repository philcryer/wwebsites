<?php
/*
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2005 Bharat Mediratta
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 * $Id: gpl.txt,v 1.7 2005/03/09 19:28:48 jenst Exp $
 */
?>
<?php
/* 
 * Protect against very old versions of 4.0 (like 4.0RC1) which  
 * don't implicitly create a new stdClass() when you use a variable 
 * like a class. 
 */ 
if (!isset($gallery)) { 
        $gallery = new stdClass(); 
}
if (!isset($gallery->app)) { 
        $gallery->app = new stdClass(); 
}

/* Version  */
$gallery->app->config_version = '92';

/* Features */
$gallery->app->feature["zip"] = 1;
$gallery->app->feature["rewrite"] = 1;
$gallery->app->feature["mirror"] = 0; // (missing <i>mirrorSites</i> -- it's optional)

/* Constants */
$gallery->app->galleryTitle = "phil cryer: art";
$gallery->app->useIcons = "no";
$gallery->app->skinname = "none";
$gallery->app->uploadMode = "form";
$gallery->app->albumDir = "/usr/local/www/data-dist/phil/art/gallery/albums";
$gallery->app->tmpDir = "/tmp";
$gallery->app->photoAlbumURL = "http://pepe.cryer.us/phil/art/gallery";
$gallery->app->albumDirURL = "http://pepe.cryer.us/phil/art/gallery/albums";
$gallery->app->movieThumbnail = "/usr/local/www/data-dist/phil/art/gallery/images/movie.thumb.jpg";
// optional <i>mirrorSites</i> missing
$gallery->app->graphics = "ImageMagick";
$gallery->app->pnmDir = "/usr/local/bin";
$gallery->app->pnmtojpeg = "pnmtojpeg";
$gallery->app->pnmcomp = "pnmcomp";
$gallery->app->ImPath = "/usr/local/bin";
$gallery->app->autorotate = "yes";
$gallery->app->jpegImageQuality = "90";
// optional <i>geeklog_dir</i> missing
$gallery->app->albumTreeDepth = "1000";
$gallery->app->microTree = "no";
$gallery->app->highlight_size = "200";
$gallery->app->showOwners = "no";
$gallery->app->albumsPerPage = "5";
$gallery->app->showSearchEngine = "yes";
$gallery->app->slowPhotoCount = "no";
$gallery->app->gallery_thumb_frame_style = "simple_book";
$gallery->app->zipinfo = "/usr/local/bin/zipinfo";
$gallery->app->unzip = "/usr/local/bin/unzip";
// optional <i>rar</i> missing
$gallery->app->use_exif = "/usr/local/bin/jhead";
// optional <i>exiftags</i> missing
$gallery->app->use_jpegtran = "/usr/local/bin/jpegtran";
$gallery->app->default_language = "en_US";
$gallery->app->ML_mode = "3";
$gallery->app->available_lang[] = "en_US";
$gallery->app->available_lang[] = "af_ZA";
$gallery->app->available_lang[] = "bg_BG";
$gallery->app->available_lang[] = "ca_ES";
$gallery->app->available_lang[] = "cs_CZ.cp1250";
$gallery->app->available_lang[] = "cs_CZ.iso-8859-2";
$gallery->app->available_lang[] = "da_DK";
$gallery->app->available_lang[] = "de_DE";
$gallery->app->available_lang[] = "en_GB";
$gallery->app->available_lang[] = "es_ES";
$gallery->app->available_lang[] = "fi_FI";
$gallery->app->available_lang[] = "fr_FR";
$gallery->app->available_lang[] = "gl_ES";
$gallery->app->available_lang[] = "he_IL.utf8";
$gallery->app->available_lang[] = "hu_HU";
$gallery->app->available_lang[] = "is_IS";
$gallery->app->available_lang[] = "it_IT";
$gallery->app->available_lang[] = "ja_JP";
$gallery->app->available_lang[] = "ko_KR";
$gallery->app->available_lang[] = "lt_LT";
$gallery->app->available_lang[] = "nl_NL";
$gallery->app->available_lang[] = "no_NO";
$gallery->app->available_lang[] = "pl_PL";
$gallery->app->available_lang[] = "pt_BR";
$gallery->app->available_lang[] = "pt_PT";
$gallery->app->available_lang[] = "ru_RU.cp1251";
$gallery->app->available_lang[] = "ru_RU.koi8r";
$gallery->app->available_lang[] = "sl_SI";
$gallery->app->available_lang[] = "sv_SE";
$gallery->app->available_lang[] = "tr_TR";
$gallery->app->available_lang[] = "uk_UA";
$gallery->app->available_lang[] = "vi_VN";
$gallery->app->available_lang[] = "zh_CN";
$gallery->app->available_lang[] = "zh_TW";
$gallery->app->available_lang[] = "zh_TW.utf8";
$gallery->app->show_flags = "no";
$gallery->app->dateString = "%x";
$gallery->app->dateTimeString = "%c";
$gallery->app->locale_alias['en_US'] = "en_AU.ISO8859-1";
$gallery->app->locale_alias['af_ZA'] = "af_ZA.ISO8859-1";
$gallery->app->locale_alias['bg_BG'] = "bg_BG.CP1251";
$gallery->app->locale_alias['ca_ES'] = "ca_ES.ISO8859-1";
$gallery->app->locale_alias['cs_CZ.cp1250'] = "cs_CZ.ISO8859-2";
$gallery->app->locale_alias['cs_CZ.iso-8859-2'] = "cs_CZ.ISO8859-2";
$gallery->app->locale_alias['da_DK'] = "da_DK.ISO8859-1";
$gallery->app->locale_alias['de_DE'] = "de_DE.ISO8859-1";
$gallery->app->locale_alias['en_GB'] = "en_GB.ISO8859-1";
$gallery->app->locale_alias['es_ES'] = "es_ES.ISO8859-1";
$gallery->app->locale_alias['fi_FI'] = "fi_FI.ISO8859-1";
$gallery->app->locale_alias['fr_FR'] = "fr_FR.ISO8859-1";
$gallery->app->locale_alias['he_IL.utf8'] = "he_IL.UTF-8";
$gallery->app->locale_alias['hu_HU'] = "hu_HU.ISO8859-2";
$gallery->app->locale_alias['is_IS'] = "is_IS.ISO8859-1";
$gallery->app->locale_alias['it_IT'] = "it_IT.ISO8859-1";
$gallery->app->locale_alias['ja_JP'] = "ja_JP.SJIS";
$gallery->app->locale_alias['ko_KR'] = "ko_KR.CP949";
$gallery->app->locale_alias['lt_LT'] = "lt_LT.ISO8859-4";
$gallery->app->locale_alias['nl_NL'] = "nl_NL.ISO8859-1";
$gallery->app->locale_alias['no_NO'] = "no_NO.ISO8859-1";
$gallery->app->locale_alias['pl_PL'] = "pl_PL.ISO8859-2";
$gallery->app->locale_alias['pt_BR'] = "pt_BR.ISO8859-1";
$gallery->app->locale_alias['pt_PT'] = "pt_PT.ISO8859-1";
$gallery->app->locale_alias['ru_RU.cp1251'] = "ru_RU.CP1251";
$gallery->app->locale_alias['ru_RU.koi8r'] = "ru_RU.CP1251";
$gallery->app->locale_alias['sl_SI'] = "sl_SI.ISO8859-2";
$gallery->app->locale_alias['sv_SE'] = "sv_SE.ISO8859-1";
$gallery->app->locale_alias['tr_TR'] = "tr_TR.ISO8859-9";
$gallery->app->locale_alias['uk_UA'] = "uk_UA.KOI8-U";
$gallery->app->locale_alias['zh_CN'] = "zh_CN.GB18030";
$gallery->app->locale_alias['zh_TW'] = "zh_TW.Big5";
$gallery->app->locale_alias['zh_TW.utf8'] = "zh_CN.GB18030";
$gallery->app->emailOn = "no";
// optional <i>adminEmail</i> missing
// optional <i>senderEmail</i> missing
$gallery->app->emailSubjPrefix = "[Gallery]";
// optional <i>emailGreeting</i> missing
$gallery->app->selfReg = "no";
$gallery->app->selfRegCreate = "no";
$gallery->app->multiple_create = "no";
$gallery->app->adminCommentsEmail = "no";
$gallery->app->adminOtherChangesEmail = "no";
// optional <i>email_notification</i> missing
$gallery->app->useOtherSMTP = "no";
$gallery->app->smtpHost = "localhost";
$gallery->app->smtpFromHost = "pepe.cryer.us";
$gallery->app->smtpPort = "25";
// optional <i>smtpUserName</i> missing
// optional <i>smtpPassword</i> missing
$gallery->app->gallery_slideshow_type = "off";
$gallery->app->gallery_slideshow_length = "20";
$gallery->app->gallery_slideshow_loop = "yes";
$gallery->app->slideshowMode = "high";
$gallery->app->comments_enabled = "yes";
$gallery->app->comments_indication = "photos";
$gallery->app->comments_indication_verbose = "no";
$gallery->app->comments_anonymous = "no";
$gallery->app->comments_display_name = "!!FULLNAME!! (!!USERNAME!!)";
$gallery->app->comments_addType = "popup";
$gallery->app->comments_length = "300";
$gallery->app->comments_overview_for_all = "no";
// optional <i>watermarkDir</i> missing
$gallery->app->watermarkSizes = "0";
// optional <i>stats_foruser</i> missing
$gallery->app->stats_viewsCacheOn = "0";
$gallery->app->stats_viewsCacheExpireSecs = "60";
$gallery->app->stats_commentsCacheOn = "0";
$gallery->app->stats_commentsCacheExpireSecs = "600";
$gallery->app->stats_dateCacheOn = "0";
$gallery->app->stats_dateCacheExpireSecs = "-1";
$gallery->app->stats_votesCacheOn = "0";
$gallery->app->stats_votesCacheExpireSecs = "3600";
$gallery->app->stats_ratingsCacheOn = "0";
$gallery->app->stats_ratingsCacheExpireSecs = "3600";
$gallery->app->stats_cDateCacheOn = "0";
$gallery->app->stats_cDateCacheExpireSecs = "-1";
$gallery->app->debug = "no";
$gallery->app->skipRegisterGlobals = "no";
$gallery->app->timeLimit = "30";
$gallery->app->blockRandomCache = "86400";
$gallery->app->blockRandomAttempts = "2";
$gallery->app->cacheExif = "no";
$gallery->app->devMode = "no";
$gallery->app->useSyslog = "no";
$gallery->app->use_flock = "yes";
$gallery->app->expectedExecStatus = "0";
$gallery->app->sessionVar = "gallery_session";
$gallery->app->rssEnabled = "yes";
$gallery->app->rssMode = "basic";
// optional <i>rssHighlight</i> missing
$gallery->app->rssMaxAlbums = "25";
$gallery->app->rssVisibleOnly = "yes";
$gallery->app->rssDCDate = "no";
$gallery->app->rssBigPhoto = "no";
$gallery->app->rssPhotoTag = "yes";
$gallery->app->userDir = "/usr/local/www/data/phil/art/gallery/albums/.users";

/* Defaults */
$gallery->app->default["cols"] = "3";
$gallery->app->default["rows"] = "3";
$gallery->app->default["bordercolor"] = "black";
$gallery->app->default["border"] = "1";
$gallery->app->default["font"] = "arial";
$gallery->app->default["thumb_size"] = "150";
$gallery->app->default["resize_size"] = "640";
$gallery->app->default["resize_file_size"] = "0";
$gallery->app->default["max_size"] = "off";
$gallery->app->default["max_file_size"] = "0";
$gallery->app->default["useOriginalFileNames"] = "yes";
$gallery->app->default["add_to_beginning"] = "no";
$gallery->app->default["fit_to_window"] = "no";
$gallery->app->default["use_fullOnly"] = "no";
$gallery->app->default["print_photos"] = "";
$gallery->app->default["mPUSHAccount"] = "gallery";
$gallery->app->default["ecards"] = "no";
$gallery->app->default["returnto"] = "yes";
$gallery->app->default["defaultPerms"] = "everybody";
$gallery->app->default["display_clicks"] = "yes";
$gallery->app->default["extra_fields"] = "Description";
$gallery->app->default["showDimensions"] = "no";
$gallery->app->default["item_owner_modify"] = "yes";
$gallery->app->default["item_owner_delete"] = "yes";
$gallery->app->default["item_owner_display"] = "no";
$gallery->app->default["voter_class"] = "Nobody";
$gallery->app->default["poll_type"] = "critique";
$gallery->app->default["poll_scale"] = "3";
$gallery->app->default["poll_hint"] = "Vote for this image";
$gallery->app->default["poll_show_results"] = "no";
$gallery->app->default["poll_num_results"] = "3";
$gallery->app->default["poll_orientation"] = "vertical";
$gallery->app->default["poll_nv_pairs"][0]["name"] = "Excellent";
$gallery->app->default["poll_nv_pairs"][0]["value"] = "5";
$gallery->app->default["poll_nv_pairs"][1]["name"] = "Very Good";
$gallery->app->default["poll_nv_pairs"][1]["value"] = "4";
$gallery->app->default["poll_nv_pairs"][2]["name"] = "Good";
$gallery->app->default["poll_nv_pairs"][2]["value"] = "3";
$gallery->app->default["poll_nv_pairs"][3]["name"] = "Average";
$gallery->app->default["poll_nv_pairs"][3]["value"] = "2";
$gallery->app->default["poll_nv_pairs"][4]["name"] = "Poor";
$gallery->app->default["poll_nv_pairs"][4]["value"] = "1";
$gallery->app->default["poll_nv_pairs"][5]["name"] = "";
$gallery->app->default["poll_nv_pairs"][5]["value"] = "";
$gallery->app->default["poll_nv_pairs"][6]["name"] = "";
$gallery->app->default["poll_nv_pairs"][6]["value"] = "";
$gallery->app->default["poll_nv_pairs"][7]["name"] = "";
$gallery->app->default["poll_nv_pairs"][7]["value"] = "";
$gallery->app->default["poll_nv_pairs"][8]["name"] = "";
$gallery->app->default["poll_nv_pairs"][8]["value"] = "";
$gallery->app->default["slideshow_type"] = "ordered";
$gallery->app->default["slideshow_recursive"] = "no";
$gallery->app->default["slideshow_loop"] = "yes";
$gallery->app->default["slideshow_length"] = "0";
$gallery->app->default["nav_thumbs"] = "no";
$gallery->app->default["nav_thumbs_style"] = "fixed";
$gallery->app->default["nav_thumbs_first_last"] = "no";
$gallery->app->default["nav_thumbs_prev_shown"] = "1";
$gallery->app->default["nav_thumbs_next_shown"] = "1";
$gallery->app->default["nav_thumbs_location"] = "top";
$gallery->app->default["nav_thumbs_size"] = "45";
$gallery->app->default["nav_thumbs_current_bonus"] = "15";
$gallery->app->default["album_frame"] = "simple_book";
$gallery->app->default["thumb_frame"] = "solid";
$gallery->app->default["image_frame"] = "solid";
?>
