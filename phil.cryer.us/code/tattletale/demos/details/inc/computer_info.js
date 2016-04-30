<script type="text/javascript">
/*
Script Name: Your Computer Information
Author: Harald Hope, Website: http://TechPatterns.com/
Script Source URI: http://TechPatterns.com/downloads/browser_detection.php
Version 1.0.5
Copyright (C) 29 June 2007

This program is free software; you can redistribute it and/or modify it under 
the terms of the GNU General Public License as published by the Free Software
Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT 
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

Get the full text of the GPL here: http://www.gnu.org/licenses/gpl.txt

This script requires the Full Featured Browser Detection and the Javascript Cookies scripts
to function.
You can download them here.
http://TechPatterns.com/downloads/browser_detection_php_ar.txt
http://TechPatterns.com/downloads/javascript_cookies.txt
*/

/*
If your page is XHMTL 1 strict, you have to
put this code into a js library file or your
page will not validate
*/
function client_data(info)
{
	if (info == 'width')
	{
		width_height_html = '<h4  class="right-bar">Current Screen Resolution</h4>';
		width = (screen.width) ? screen.width:'';
		height = (screen.height) ? screen.height:'';
		width_height_html += '<p class="right-bar">' + width + " x " +
			height + " pixels</p>";
		(width && height) ? document.write(width_height_html):'';
	}
	else if (info == 'js' )
	{
		document.write('<p class="right-bar">JavaScript is enabled.</p>');
	}
	else if ( info == 'cookies' )
	{
		expires ='';
		Set_Cookie( 'cookie_test', 'it_worked' , expires, '', '', '' );
		string = '<h4  class="right-bar">Cookies</h4><p class="right-bar">';
		if ( Get_Cookie( 'cookie_test' ) )
		{
			string += 'Cookies are enabled</p>';
		}
		else {
			string += 'Cookies are disabled</p>';
		}
		document.write( string );
	}
}
</script>

<div class="float-left-01">
		<h3 class="h-right-bar">Your Computer</h3>
			<?php
			$os = '<h4 class="right-bar">Operating System:</h4><p class="right-bar">';
			$full = '';
			// change these two to match your include path/and file name you give the script
			include('browser_detection.php');
			$browser_info = browser_detection('full');
			
			$browser_info[] = browser_detection('moz_version');

			switch ($browser_info[5])
			{
				case 'win':
					$os .= 'Windows ';
					break;
				case 'nt':
					$os .= 'Windows<br />NT ';
					break;
				case 'lin':
					$os .= 'Linux<br /> ';
					break;
				case 'mac':
					$os .= 'Mac ';
					break;
				case 'unix':
					$os .= 'Unix<br />Version: ';
					break;
				default:
					$os .= $browser_info[5];
			}

			if ( $browser_info[5] == 'nt' )
			{
				if ($browser_info[6] == 5)
				{
					$os .= '5.0 (Windows 2000)';
				}
				elseif ($browser_info[6] == 5.1)
				{
					$os .= '5.1 (Windows XP)';
				}
			}
			elseif ( ( $browser_info[5] == 'mac' ) &&  ( $browser_info[6] >= 10 ) )
			{
				$os .=  'OS X';
			}
			elseif ( $browser_info[5] == 'lin' )
			{
				$os .= ( $browser_info[6] != '' ) ? 'Distro: ' . ucfirst ($browser_info[6] ) : 'Smart Move!!!';
			}
			elseif ( $browser_info[6] == '' )
			{
				$os .=  ' (version unknown)';
			}
			else
			{
				$os .=  strtoupper( $browser_info[6] );
			}

			$full .= $os . '</p><h4 class="right-bar">Current Browser:</h4><p class="right-bar">';
			if ($browser_info[0] == 'moz' )
			{
				$a_temp = $browser_info[count( $browser_info ) - 1];// the moz array is last item
				$full .= ($a_temp[0] != 'mozilla') ? 'Mozilla/ ' . ucfirst($a_temp[0]) . ' ' : ucfirst($a_temp[0]) . ' ';
				$full .= $a_temp[1] . '<br />';
				$full .= 'ProductSub: ';
				$full .= ( $a_temp[4] != '' ) ? $a_temp[4] . '<br />' : 'Not Available<br />';
				$full .= ($a_temp[0] != 'galeon')?'RV version: ' . $a_temp[3] : '';
			}
			elseif  ( $browser_info[0] == 'ns' )
			{
				$full .= 'Netscape ';
				$full .= $browser_info[1] . '<br />';
			}
			else
			{
				$full .= ($browser_info[0] == 'ie') ? strtoupper($browser_info[7]) : ucwords($browser_info[7]);
				$full .= ' ' . $browser_info[1];
			}
			echo $full . '</p>';
			?>
			<script type="text/javascript">
				client_data('width');
			</script>
			<h4 class="right-bar">JavaScript</h4>
			<script type="text/javascript">
				client_data('js');
			</script>
			<noscript>
			<p class="right-bar">JavaScript is disabled</p>
			</noscript>
			<script type="text/javascript">
				client_data('cookies');
			</script>
	</div>
