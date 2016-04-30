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
 * $Id: services.php,v 1.1 2005/05/09 17:13:14 jenst Exp $
 */
?>
<?php

$services = array(
    'photoaccess' => array(
	'name'    => 'PhotoWorks',
	'url'     => 'http://www.photoworks.com/'
    ),
    'shutterfly'  => array(
	'name'    => 'Shutterfly',
	'url'     => 'http://www.shutterfly.com/'
    ),
    'fotoserve'  => array(
	'name'    => 'Fotoserve.com',
	'url'     => 'http://www.fotoserve.com/'
    ),
    'fotokasten'  => array(
	'name'    => 'Fotokasten',
	'url'     => 'http://www.fotokasten.de/'
    ),
    'mpush'       => array(
	'name'    => 'mPUSH',
	'url'     => 'http://www.mpush.cc/',
	'description' => _("mPUSH is a photo service that adds the ability to send thumbnail images to your, or a friend's, cellphone for a small fee.")
    )
);
?>