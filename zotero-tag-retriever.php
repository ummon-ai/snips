
<!-- 
Script : Zotero API tag retriever
Description: Get the tags for your Zotero collection using the Zotero API. Print them out in a webpage (Wordpress etc.).    	     
Author: Aatu Poutanen (aasapo@utu.fi)
Free to use and modify. 		   	
-->

<?php

// Define variables.

$StartFrom = 0; 
$NumTags = 70;
$x=0;

/* Define API request*/
/* Run the script x times. */
while ($x < 3) {
		$request = wp_remote_get( "https://api.zotero.org/users/XXXXXX/collections/XXXXXX/tags?&start=" . $StartFrom . "&limit=" . $NumTags); // your collection API here.
			$body = wp_remote_retrieve_body( $request );
			$data[] = json_decode( $body );
		if( is_wp_error( $request ) ) {
		echo 'Unable to retrieve tags from Zotero API';
		return;
		}	
	$StartFrom += 70;
	$x++;

}

// Extract tags to a dedicated array.

if( isset( $data ) ){
		foreach( $data as $key => $value ) {
			foreach( $value as $sub_key => $sub_value ) {
				$tags[] = $sub_value->tag;
			}
		}
}

// Organize tags by name.

function cmp($a, $b) {
    return strcmp($a["tag"], $b["tag"]);
}
usort($tags, "cmp");

// /*print tags on page, convert to links */

if( ! empty( $tags ) ) {
	foreach( $tags as $key => $value ) {
		echo '<div class="tagbutton">' . '<a href="your-wp-website-here/?tag_id=' . $value . '">' . $value . " " . '</a>'. '</div>';
			}
}
else {
	echo "Object has no data." . '<br>';
	return;
}
return;
?>

<!-- CSS to style your tags into Zotero -style buttons. Add this to your child theme or as custom CSS in WordPress.
	
.tagbutton {
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background:linear-gradient(to bottom, #ffffff 5%, #f6f6f6 100%);
	background-color:#ffffff;
	border-radius:12px;
	border:1px solid #dcdcdc;
	display:inline-block;
	cursor:pointer;
	color:#666666;
	font-family:Arial;
	font-size:15px;
	padding:3px 20px;
	text-decoration:none;
	text-shadow:0px 1px 0px #ffffff;
	font-variant: small-caps;
	padding: 15px 32px;
	letter-spacing: 1.4px;
}
.tagbutton:hover {
	background:linear-gradient(to bottom, #f6f6f6 5%, #ffffff 100%);
	background-color:#f6f6f6;
}
.tagbutton:active {
	position:relative;
	top:1px;
}
 -->
