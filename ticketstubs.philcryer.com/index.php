<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<?php include_once('resources/UberGallery.php'); ?>

<head>
    <title>Ticketstubs</title>
    
    <link rel="shortcut icon" href="images/favicon.png" />

    <link rel="stylesheet" type="text/css" href="css/rebase-min.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="resources/UberGallery.css" />
    <link rel="stylesheet" type="text/css" href="resources/colorbox/1/colorbox.css" />
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js"></script>
    <script type="text/javascript" src="resources/colorbox/jquery.colorbox.js"></script>
    
    <script type="text/javascript">
    $(document).ready(function(){
        $("a[rel='1987']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='1988']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='1989']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='1990']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='1991']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='1992']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='1993']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='1994']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='1995']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='1996']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='1997']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='1998']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='1999']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='2000']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='2001']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='2002']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='2003']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='2004']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='2005']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='2006']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='2007']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='2008']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='2009']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='2010']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='2011']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='2012']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
        $("a[rel='2013']").colorbox({maxWidth: "90%", maxHeight: "90%", opacity: ".5"});
    });
    </script>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>

<body>

    <div class="pageWrap">
        
        <h1 id="pageTitle">Ticketstubs</h1>
        
        <p>
	This is my (first) attempt at documenting the concerts I've attended via ticket stubs. It can't be conclusive since some stubs may have been lost, while many shows didn't require a ticket, cash at the door was the ticket. I want to add to this until I have all my stubs accounted for and then add meta-data for each concert; band name, year, venue, city, notes, etc that can be searched against. Direct questions or comments to phil (at) philcryer (dot) com and until then, I'll see you at the show.
        </p>
        
        <?php $files = scandir('galleries'); ?>
        <?php foreach ($files as $file): ?>
            
            <?php $dir = 'galleries/' . $file; ?>
            
            <?php if (is_dir($dir) && $file != '.' && $file != '..'): ?>
                <h2><?php echo ucwords($file); ?></h2>
                <?php $gallery = UberGallery::init()->createGallery($dir, $file); ?>
            <?php endif; ?>
            
        <?php endforeach; ?>
                
        <div id="credit">Last updated 20131229 &nbsp;|&nbsp; Powered by <a href="http://debian.org">Debian</a>, <a href="http://nginx.org">Nginx</a> and <a href="http://www.ubergallery.net">UberGallery</a></div>
    </div>

</body>

<!-- Page template by, Chris Kankiewicz <http://www.chriskankiewicz.com> -->

</html>
