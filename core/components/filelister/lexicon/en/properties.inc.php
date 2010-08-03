<?php
/**
 * FileLister
 *
 * Copyright 2010 by Shaun McCormick <shaun@modxcms.com>
 *
 * This file is part of FileLister, a file listing Extra.
 *
 * FileLister is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * FileLister is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * FileLister; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package filelister
 */
/**
 * Default Lexicon Topic
 *
 * @package filelister
 * @subpackge lexicon
 */
$_lang['feo.filename'] = 'File Name';
$_lang['feo.date'] = 'Date';
$_lang['feo.size'] = 'Size';
$_lang['feo.extension'] = 'Extension';
$_lang['feo.asc'] = 'Ascending';
$_lang['feo.desc'] = 'Descending';
$_lang['prop_feo.path_desc'] = 'The path to browse from.';
$_lang['prop_feo.filetpl_desc'] = 'The chunk for each file listing.';
$_lang['prop_feo.directorytpl_desc'] = 'The chunk for each directory listing.';
$_lang['prop_feo.filelinktpl_desc'] = 'The chunk for the links for each listing.';
$_lang['prop_feo.dateformat_desc'] = 'A PHP date format for the last modified field.';
$_lang['prop_feo.outputseparator_desc'] = 'A separator that is appended to each listing.';
$_lang['prop_feo.skipdirs_desc'] = 'A comma-separated list of directory names to always skip.';
$_lang['prop_feo.placeholderprefix_desc'] = 'The prefix to append to all global placeholders set by the snippet.';
$_lang['prop_feo.pathseparator_desc'] = 'The separator between items generated in the +path placeholder.';
$_lang['prop_feo.pathtpl_desc'] = 'The chunk for each item in the +path placeholder.';
$_lang['prop_feo.showfiles_desc'] = 'If false, will hide any files from the listing.';
$_lang['prop_feo.showdirectories_desc'] = 'If false, will hide any directories from the listing.';
$_lang['prop_feo.showext_desc'] = 'A comma-separated list of extensions to restrict output of files to. If blank, all files will be shown. If any are specified, only files with those extensions will be shown.';
$_lang['prop_feo.sortby_desc'] = 'The metric to sort by for each file.';
$_lang['prop_feo.sortdir_desc'] = 'The direction to sort by for each file.';
$_lang['prop_feo.allowdownload_desc'] = 'If false, will disable viewing and downloads of any files.';
$_lang['prop_feo.requireauthdownload_desc'] = 'If true, will require users be logged in to view or download a file.';
$_lang['prop_feo.allowdownloadgroups_desc'] = 'A comma-separated list that, if set, will restrict file viewing/downloading to users in the specified groups.';
$_lang['prop_feo.showdownloads_desc'] = 'If true, will show download counts next to files.';
$_lang['prop_feo.uniquedownloads_desc'] = 'If true, will show only unique downloads - meaning one download count per IP.';
$_lang['prop_feo.toplaceholder_desc'] = 'If set, will set the output to a placeholder with the specified name rather than directly outputting it.';
$_lang['prop_feo.navkey_desc'] = 'The REQUEST navigation key used for the browsing.';