<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<div class="alert alert-warning" role="alert">
  Ovo je za testiranje scrapeanja ostalih podataka sa stranice kao drop chance. Ex. id:63043
</div>

<form action="profile.php" method="post">
id: <input type="text" name="id"><br>
<input type="submit">
<pre>
<?php


function xml_to_array($root) {
    $result = array();

    if ($root->hasAttributes()) {
        $attrs = $root->attributes;
        foreach ($attrs as $attr) {
            $result['@attributes'][$attr->name] = $attr->value;
        }
    }

    if ($root->hasChildNodes()) {
        $children = $root->childNodes;
        if ($children->length == 1) {
            $child = $children->item(0);
            
                $result['_value'] = $child->nodeValue;
                return count($result) == 1
                    ? $result['_value']
                    : $result;
            
        }
        $groups = array();
        foreach ($children as $child) {
            if (!isset($result[$child->nodeName])) {
                $result[$child->nodeName] = xml_to_array($child);
            } else {
                if (!isset($groups[$child->nodeName])) {
                    $result[$child->nodeName] = array($result[$child->nodeName]);
                    $groups[$child->nodeName] = 1;
                }
                $result[$child->nodeName][] = xml_to_array($child);
            }
        }
    }

    return $result;
}
if (isset($_POST['id']))
{

	$html=file_get_contents('https://www.wowhead.com/item='.$_POST['id']);
	$dom = new DOMDocument;
	$dom->loadHTML($html);
	$html=$dom->saveXML();
	#echo $html;
	$array=xml_to_array($dom);
	function filter(&$value) {
  	$value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	}
	array_walk_recursive($array, "filter");
	//print_r($array);
	#$xml = simplexml_load_string($html, "SimpleXMLElement", LIBXML_NOCDATA);
    #print_r($xml);
        #die();
	#$xml = simplexml_load_string( $xmlstring , null , LIBXML_NOCDATA ); 
	#$xml = simplexml_load_string($html, "SimpleXMLElement", LIBXML_NOCDATA);
	#$json = json_encode($xml);
	#$array = json_decode($json,TRUE);
	#$array = new SimpleXMLElement($html);
	#xml_parse_into_struct(xml_parser_create(),$html,$array);print_r($array);
	echo end(explode(',', $array['html'][1]['head']['meta'][5]['@attributes']['content']));
	$var=explode(',',explode(';', $array['html'][1]['body']['div'][3]['div'][1]['div'][3]['div'][1]['script'][2]['_value'])[39]);
	#print_r($array['html'][1]['body']['div'][3]['div'][1]['div']);
	$count=(int)explode(":",$var[1])[1];
	$outof=(int)explode(":",$var[2])[1];
	echo "<br>";
	echo round($count/$outof*100,2);
	
}


?>
</pre>