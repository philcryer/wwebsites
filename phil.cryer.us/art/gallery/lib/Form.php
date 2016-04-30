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
 * $Id: Form.php,v 1.21 2005/05/23 12:39:04 jenst Exp $
 */
?>
<?php 

function insertFormJS($formName) {

?>
<script type="text/javascript" language="javascript">
// <!-- 
function setCheck(val,elementName) {
	ufne=document.<?php echo $formName; ?>;
	len = ufne.elements.length;
	for(i = 0 ; i < len ; i++) {
		if (ufne.elements[i].name==elementName) {
			ufne.elements[i].checked=val;
		}
	}
}

function invertCheck(elementName) {
	ufne=document.<?php echo $formName; ?>;
	len = ufne.elements.length;
	for(i = 0 ; i < len ; i++) {
		if (ufne.elements[i].name==elementName) {
			ufne.elements[i].checked = !(ufne.elements[i].checked);
		}
	}
}
// -->
</script>
<?php
}

function insertFormJSLinks($elementName) {
$buf='
	<a href="javascript:setCheck(1,\'' . $elementName . '\')">'. _("Check All") . '</a>
	-
	<a href="javascript:setCheck(0,\'' . $elementName . '\')">'. _("Clear All") . '</a>
	-
	<a href="javascript:invertCheck(\'' . $elementName . '\')">'. _("Invert Selection") .'</a>';

return $buf;
}

/*
** $opts is now a name/value array, where $key is the value returned, and $name
** is the value displayed (and translated).
*/

function selectOptions($album, $field, $opts) {
	foreach ($opts as $key => $value) {
		$sel = "";
		if (isset($album->fields[$field]) && !strcmp($key, $album->fields[$field])) {
			$sel = "selected";
		}
		echo "\n\t<option value=\"$key\" $sel>$value</option>";
	}
	echo "\n";
}


function drawSelect($name, $options, $selected, $size, $attrList=array(), $prettyPrinting = false) {
	$attrs = "";
	$crlf = ($prettyPrinting) ? "\n\t" : '';

	if (!empty($attrList)) {
		$attrs = " ";
		foreach ($attrList as $key => $value) {
			if ($value == NULL) {
				$attrs .= " $key";
			}
			else {
				$attrs .= " $key=\"$value\"";
			}
		}
	}

	$buf = "";
	$buf .= "<select name=\"$name\" size=\"$size\"$attrs>" . $crlf;
	foreach ($options as $value => $text) {
		$sel = "";
		if (is_array($selected)) {
			if (in_array($value, $selected)) {
				$sel = " selected";
			}
		}
		else if (!strcmp($value, $selected) || !strcmp($text, $selected)) {
			$sel = " selected";
                }
		$buf .= "<option value=\"$value\"$sel>". $text ."</option>" . $crlf;
	}
	$buf .= "</select>". $crlf;

	return $buf;
}

/*
 * makeFormIntro() is a wrapper around makeGalleryUrl() that will generate
 * a <form> tag suitable for usage in either standalone or embedded mode.
 * You can specify the additional attributes you want in the optional second
 * argument.  Eg:
 *
 * makeFormIntro("add_photos.php",
 *                      array("name" => "count_form",
 *                              "enctype" => "multipart/form-data",
 *                              "method" => "POST"));
 */
function makeFormIntro($target, $attrList=array(), $urlargs=array()) {

	// We don't want the result HTML escaped since we split on "&", below
	// use the header version of makeGalleryUrl()
	$url = makeGalleryHeaderUrl($target, $urlargs);

	$result = split("\?", $url);
	$target = $result[0];
	if (sizeof($result) > 1) {
		$tmp = $result[1];
	} else {
		$tmp = "";
	}

	$attrs = '';
	foreach ($attrList as $key => $value) {
		$attrs .= " $key=\"$value\"";
	}

	$form = "\n<form action=\"$target\" $attrs>\n";

	$args = split("&", $tmp);
	foreach ($args as $arg) {
		if (strlen($arg) == 0) {
			continue;
		}
		list($key, $val) = split("=", $arg);
		$form .= "<input type=\"hidden\" name=\"$key\" value=\"$val\">\n";
	}
	return $form;
}

function formVar($name) {
	if (!strncmp($_REQUEST[$name], 'false', 5)) {
		return false;
	} else {
		return getRequestVar($name); 
	}
}


function emptyFormVar($name) {
	return !isset($_REQUEST[$name]);
}

/* The code below was inspired from the Horde Framework (http://www.horde.org)
** It was taken from: framework/UI/UI/VarRenderer/html.php,v 1.106
** Copyright 2003-2005 Jason M. Felice <jfelice@cronosys.com>
**
** Jens Tkotz 25.04.2005
*/
function showColorpicker($attrs = array()) {
    $imgColorpicker = '<img src="'. getImagePath('colorpicker.png') .'" height="16"></a></td>';
    $colorPickerUrl = makeGalleryUrl('lib/colorpicker.php', array('target' => $attrs['name'], 'gallery_popup' => true));

    $html = '<table border="0" cellspacing="0">';
    $html .= '<tr>';
    $html .= '<td><input type="text" size="10" maxlength="7" name="'. $attrs['name'] .'" id="'. $attrs['name'] .'" value="'. $attrs['value'] .'"></td>';
    $html .= '<td width="20" id="colordemo_' . $attrs['name'] . '" style="background-color:' . $attrs['value'] . '"> </td>';
    $html .= "<td><a href=\"$colorPickerUrl\" onclick=\"window.open('$colorPickerUrl', 'colorpicker', 'toolbar=no,location=no,status=no,scrollbars=no,resizable=no,width=120,height=250,left=100,top=100'); return false;\" onmouseout=\"window.status='';\" onmouseover=\"window.status='". _("Colorpicker") ."'; return true;\" target=\"colorpicker\">".  $imgColorpicker .'</a></td>'; 
    $html .= '<td><div id="colorpicker_' . $attrs['name'] . '" class="control"></div></td>';
    $html .= '</tr></table>';

    return $html;
}
?>