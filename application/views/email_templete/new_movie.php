<?php
    $message ='
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>New Movie Published </title>    
        </head>

        <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
            <center>
                <table style="padding:30px 10px;background:#F4F4F4;width:100%;font-family:arial" cellpadding="0" cellspacing="0">
                        
                        <tbody>
                            <tr>
                                <td>
                                
                                    <table style="max-width:840px;min-width:320px" align="center" cellspacing="0">
                                        <tbody>
                                        
                                            <tr>
                                                <td style="background:#fff;border:1px solid #D8D8D8;padding:30px 30px" align="center">
                                                
                                                    <table align="center">
                                                        <tbody>
                                                        
                                                            <tr>
                                                                <td style="border-bottom:1px solid #D8D8D8;color:#666;text-align:center;padding-bottom:30px">
                                                                    
                                                                    <table style="margin:auto" align="center">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="color:#005f84;font-size:22px;font-weight:bold;text-align:center;font-family:arial">
                                                                        
                                                                                    <img border="0" align="center" src="'.$logo.'" style="margin-top: 0px; margin-bottom: 0px; padding: 0px 10px 10px 0px; height: 50px;" data-mce-style="margin-top: 0px; margin-bottom: 0px; padding: 0px 10px 0px 0px; height: 150px;">
                                                                                    
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="color:#005f84;font-size:22px;font-weight:bold;text-align:center;font-family:arial">
                                                                        
                                                                                    '.trans('site_title').'
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            
                                                            <tr>
                                                       <td style="color:#666;padding:15px; padding-bottom:0;font-size:14px;line-height:20px;font-family:arial;text-align:center;">
                                            
                                                            <h1  class=""><span style="color:#005f84;padding-bottom:30px;font-family: impact, sans-serif;" data-mce-style="font-family: impact, sans-serif;">'.$video->title.'</span></h1>
                                                            <h4  style="color:#005f84;padding-bottom:10px;" data-mce-style="font-family: impact, sans-serif;">by &nbsp;'.trans('site_title').'</h4>

                                                            <div style="font-style:normal;padding-bottom:15px;font-family:arial;line-height:20px;text-align:left">
                                                                <img border="0" class="content-image  " align="left" src="'.$thumb_image.'" style="display: inline-block; margin: 0px; padding: 0px 20px 10px 0px; width: 250px;">

                                                                <div style="margin: 0px 0px 10px 0px; line-height: 22px;text-align: left;"><span style="color: rgb(51, 51, 51); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;">'.$video->description.'</span></div>
                                                                                                                    
                                                                
                                                                <p><span style="font-weight:bold;font-size:16px">'.trans('release').':</span> '.$video->release.'</p>
                                                                <p><span style="font-weight:bold;font-size:16px">'.trans('actor').': </span> '.$actor.'</p>
                                                                <p><span style="font-weight:bold;font-size:16px">'.trans('director').': </span> '.$director.'</p>                                                                
                                                                <p><span style="font-weight:bold;font-size:16px">'.trans('duration').':</span> '.$video->runtime.'</p>
                                                                <p><span style="font-weight:bold;font-size:16px">'.trans('imdb_rating').': </span> '.$video->imdb_rating.'</p>
                                                                <p><span style="font-weight:bold;font-size:16px"><a style="margin-top: 10px; background-color: rgb(31, 148, 21); font-family: Arial; color: rgb(255, 255, 255); display: inline-block; border-radius: 6px; text-align: center; padding: 12px 20px; text-decoration: none;" class="button-1 hyperlink" href="'.$watch_url.'.html" data-default="1">WATCH ONLINE</a></p>

                                                            </div>
                                                            <div>
                                                                
                                                            </div>

                                                                    
                                                                </td>
                                                            </tr>
                                                            
                                                        </tbody>
                                                    </table>
                                                    
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    <table style="max-width:650px" align="center">
                                        <tbody>
                                            <tr>
                                                <td style="color:#b4b4b4;font-size:11px;padding-top:10px;line-height:15px;font-family:arial">
                                                    <span> &copy; '.date("Y").' '.trans('site_title').' - ALL RIGHTS RESERVED </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                    </tbody>
                </table>
            </center>
        </body>
        </html>
    ';
?>