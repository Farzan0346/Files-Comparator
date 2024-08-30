<?php

namespace App\Livewire\Org\Omparator;

use Livewire\Component;
use Livewire\WithFileUploads;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Renderer\RendererConstant;

class OmparatorForm extends Component
{
    use WithFileUploads;

    public $file1, $file2;
    public $diff;

    public function submit()
    {
        // Validate uploaded files
        $this->validate([
            'file1' => 'required|file|mimes:xml',
            'file2' => 'required|file|mimes:xml',
        ]);
        function normalizeXml($xml) {
            $dom = new \DOMDocument();
            $dom->preserveWhiteSpace = false; // Preserve the original formatting
            $dom->formatOutput = false;
            $dom->loadXML($xml);
        
            // Create XPath to traverse and normalize text nodes
            $xpath = new \DOMXPath($dom);
        
            // Normalize text nodes
            foreach ($xpath->query('//text()') as $textNode) {
                // Trim the text and collapse multiple spaces into a single space
                $normalizedText = preg_replace('/\s+/u', ' ', trim($textNode->nodeValue));
                $textNode->nodeValue = $normalizedText;
            }
        
            return $dom->saveXML();
        }

        
        
        // $simplexml1 = simplexml_load_file($this->file1->getRealPath());
        // $simplexml2 = simplexml_load_file($this->file2->getRealPath());


        // $xml1 = file_get_contents($this->file1->getRealPath());
        // $xml2 = file_get_contents($this->file2->getRealPath());

        
        
        function xmlToKeyValueArray($xml) {
            $result = [];
        
            // Recursively parse the SimpleXMLElement
            foreach ($xml as $key => $value) {
                // Prepare an array for this element's data
                $elementData = [];
                
                // If the element has children, recursively parse them
                if ($value->children()->count() > 0) {
                    $elementData = xmlToKeyValueArray($value);
                } else {
                    // If the element has no children, store its value
                    $elementData['@value'] = (string) $value;
                }
        
                // If the element has attributes, add them to the array
                if ($value->attributes()) {
                    foreach ($value->attributes() as $attrKey => $attrValue) {
                        $elementData['@attributes'][$attrKey] = (string) $attrValue;
                    }
                }
        
                // Check if this key already exists
                if (isset($result[$key])) {
                    // Convert existing single element to an array if it isn't already
                    if (!is_array($result[$key]) || !isset($result[$key][0])) {
                        $result[$key] = [$result[$key]];
                    }
        
                    // Append the current element's data to the array
                    $result[$key][] = $elementData;
                } else {
                    // Otherwise, initialize this key with the element's data
                    $result[$key] = $elementData;
                }
            }
        
            return $result;
        }
        
        
        // Load XML file
        $xml1FilePath = $this->file1->getRealPath();
        $xml2FilePath = $this->file2->getRealPath();
        $newxml1 = simplexml_load_file($xml1FilePath);
        $newxml2 = simplexml_load_file($xml2FilePath);
        
        // Convert XML to key-value array
        $keyValueArray_1 = xmlToKeyValueArray($newxml1);
        $keyValueArray_2 = xmlToKeyValueArray($newxml2);
        // $xml1 = $keyValueArray_1;
        // $xml2 = $keyValueArray_2;
        // dd($keyValueArray_1,$keyValueArray_2);
        // dd($keyValueArray_2);
        // dd($xml1,$xml2);
        // function parseXmlToObjectForm($reader) {
        //     $node = new \stdClass(); // Root object to store all parsed elements
        //     $node->children = []; // Initialize children as an array to store child elements and text
        
        //     // Read through the XML document
        //     while ($reader->read()) {
        //         if ($reader->nodeType == \XMLReader::ELEMENT) {
        //             $name = $reader->name; // Current element name
        //             $element = new \stdClass(); // New object to store the current element's data
        //             $element->name = $name; // Store the element name
        
        //             // Process attributes
        //             if ($reader->hasAttributes) {
        //                 $element->attributes = [];
        //                 while ($reader->moveToNextAttribute()) {
        //                     $element->attributes[$reader->name] = $reader->value;
        //                 }
        //                 $reader->moveToElement(); // Move back to the element node
        //             }
        
        //             // Process child elements or text
        //             if (!$reader->isEmptyElement) {
        //                 $depth = $reader->depth;
        //                 $element->children = [];
        
        //                 // Read all child nodes and text content
        //                 while ($reader->read()) {
        //                     if ($reader->nodeType == \XMLReader::END_ELEMENT && $reader->depth == $depth) {
        //                         break; // End of the current element
        //                     }
        
        //                     if ($reader->nodeType == \XMLReader::ELEMENT) {
        //                         $element->children[] = parseXmlToObjectForm($reader); // Recursive call for child elements
        //                     } elseif ($reader->nodeType == \XMLReader::TEXT || $reader->nodeType == \XMLReader::CDATA) {
        //                         $element->children[] = $reader->value; // Store text content
        //                     }
        //                 }
        //             }
        
        //             // Add the element to the node object
        //             $node->children[] = $element;
        
        //         } elseif ($reader->nodeType == \XMLReader::TEXT || $reader->nodeType == \XMLReader::CDATA) {
        //             // Collect text nodes
        //             return $reader->value; // Return text content for text or CDATA nodes
        //         } elseif ($reader->nodeType == \XMLReader::END_ELEMENT) {
        //             // End of the current element
        //             return $node; // Return the fully constructed node object
        //         }
        //     }
        
        //     return $node; // Return the final parsed object after reading all nodes
        // }
        
        // function parseXmlFile($filePath) {
        //     $reader = new \XMLReader();
        //     $reader->open($filePath); // Open the XML file
        
        //     // Parse the XML and convert it to an object
        //     $xmlObject = parseXmlToObjectForm($reader);
        //     $reader->close(); // Close the XML file
        
        //     return $xmlObject;
        // }
        
        // Example usage with XML files
        // $xml1parsed = parseXmlFile($this->file1->getRealPath());
        // $xml2parsed = parseXmlFile($this->file2->getRealPath());
       
        

        
        $dates_1 =[];
        $dates_2 =[];
        $found_index_1 = [];
        $found_index_2 = [];
        // dd($keyValueArray_1, $keyValueArray_2, $differences);
        if (array_key_exists('traveldates', $keyValueArray_1) && array_key_exists('traveldates', $keyValueArray_2)) {
            if (array_key_exists('traveldate', $keyValueArray_1['traveldates']) && array_key_exists('traveldate', $keyValueArray_2['traveldates'])) {
                $traveldate1 =  $keyValueArray_1['traveldates']['traveldate'];
                
               $dates_1 = $keyValueArray_1['traveldates']['traveldate'];
                $dates_2 = $keyValueArray_2['traveldates']['traveldate'];
                unset($keyValueArray_1['traveldates']);
                unset($keyValueArray_2['traveldates']);
                if( is_array($dates_1) && is_array($dates_2) ){
                    $from1 = [];
                    $from2 = [];
                    $to1 = [];
                    $to2 = [];
                    $attr_from = [];
                    $attr_to = [];
                    $attr_1 = [];
                    $attr_2 = [];
                    $result = [];
                    $found_index =[];
                    $new_index = [];

                    foreach($dates_1 as $key1 => $val1){
                        if(is_array($val1)){
                            $from_1 = $val1['@attributes']['from'];
                            $to_1 = $val1['@attributes']['to'];
                            $attr_1[$key1] = ['from' => $from_1,'to' =>$to_1];
                            
                            
                        }
                    }
                    foreach($dates_2 as $key2 => $val2){
                        if(is_array($val2)){
                            $from_2 = $val2['@attributes']['from'];
                            $to_2 = $val2['@attributes']['to'];
                            $attr_2[$key2] = ['from' => $from_2,'to' =>$to_2];
                        }
                    }

                    foreach ($attr_1 as $index => $dateRange1) {
                            $found = false;
                            foreach($attr_2 as $index2 => $dateRange2){
                                if ($dateRange1['from'] === $dateRange2['from'] && $dateRange1['to'] === $dateRange2['to']) {
                                    $result[] = ['Exist in both' => $dateRange1];
                                    $found = true;
                                    $found_index[] = $index2;
                                    $found_index_1[] = $index;
                                    $found_index_2[] = $index2;
                                    break;
                                } 

                            }
                            if(!$found){

                                $result[] = ['Existed in file 1 but not in file 2' => $dateRange1];

                            }
                    }
                    foreach($attr_2 as $index2 => $dateRange2){
                        
                        if (!in_array($index2, $found_index, true)) {
                            // If the index from $attr_2 is not in $found_indices, it means it wasn't matched
                            $result[] = ['Existed in file 2 but not in file 1' => $dateRange2];
                        }
                    }
                    foreach($found_index_1 as $index1xml => $val1){
                        $temp_index1 = $val1;
                        $dates_1[$index1xml] = $dates_1[$temp_index1];
                    }
                    foreach($found_index_2 as $index2Xml => $val2){
                        // $trave_date
                        $temp_index = $val2;
                        $dates_2[$index2Xml] = $dates_2[$temp_index];
                        // $dates_2[$temp_index] = $dates_2[$index2Xml];

                    }
                    // foreach( $dates_1 as $dateIndex => $dateValue){
                    //     $dates_1['traveldate'] = $dateValue;
                    // }
                }
            }
        }
        // dd($dates_1,$dates_2);
        

        $xml1Content = file_get_contents($this->file1->getRealPath());
        $xml2Content = file_get_contents($this->file2->getRealPath());
        $xml1 = normalizeXml($xml1Content);
        $xml2 = normalizeXml($xml2Content);

        // $xml1Object = simplexml_load_string($xml1Content, 'SimpleXMLElement', LIBXML_NOENT | LIBXML_NOCDATA);
        // $xml2Object = simplexml_load_string($xml2Content, 'SimpleXMLElement', LIBXML_NOENT | LIBXML_NOCDATA);

        // // Check for errors
        // if ($xml1Object === false) {
        //     dd( "Failed loading XML\n");
        //     // foreach(libxml_get_errors() as $error) {
        //     //     echo "\t", $error->message;
        //     // }
        // } else {
        //     // Successfully parsed, now you can work with the SimpleXML object
        //     dd($xml1Object,$xml2Object);
        // }


        // $diffOptions = [
        //     'context' => 1,
        //     'ignoreCase' => true,
        //     'ignoreLineEnding' => true,
        //     'ignoreWhitespace' => true,
        //     'lengthLimit' => 2000,
        //     'fullContextIfIdentical' => false,
        // ];
        // // options for renderer class
        // $rendererOptions = [
        //     'detailLevel' => 'char', // Change to 'char' for character-level diff
        //     'language' => 'eng',
        //     'lineNumbers' => true,
        //     'separateBlock' => true,
        //     'showHeader' => true,
        //     'spaceToHtmlTag' => false,
        //     'spacesToNbsp' => false,
        //     'tabSize' => 4,
        //     'mergeThreshold' => 1,
        //     'cliColorization' => RendererConstant::CLI_COLOR_AUTO,
        //     'outputTagAsString' => false,
        //     'jsonEncodeFlags' => \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE,
        //     'wordGlues' => [' ', '-'],
        //     'resultForIdenticals' => 'Both Files Are Identical',
        //     'wrapperClasses' => ['diff-wrapper'],
        // ];

        // options for Diff class
        $diffOptions = [
            'context' => 1,
            'ignoreCase' => true,
            'ignoreLineEnding' => true,
            'ignoreWhitespace' => true,
            'lengthLimit' => 10000,
            'fullContextIfIdentical' => true,
        ];
        // // options for renderer class
        $rendererOptions = [
            'detailLevel' => 'char', // Change to 'char' for character-level diff
            'language' => 'eng',
            'lineNumbers' => true,
            'separateBlock' => true,
            'showHeader' => true,
            'spaceToHtmlTag' => false,
            // 'spacesToNbsp' => false,
            'tabSize' => 4,
            'mergeThreshold' => 1,
            'cliColorization' => RendererConstant::CLI_COLOR_AUTO,
            'outputTagAsString' => true,
            'jsonEncodeFlags' => \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE,
            'wordGlues' => [' ', '-'],
            'resultForIdenticals' => 'Both Files Are Identical',
            'wrapperClasses' => ['diff-wrapper'],
        ];
        // foreach($keyValueArray_1 as $index1 => $value1){}
        // $stringArray1 = implode('',$keyValueArray_1);
        // $stringArray2 = implode('',$keyValueArray_2);
        // dd($stringArray1, $stringArray2);
        function arrayToXml($data, &$xmlData, $traveldate = '') {
            foreach ($data as $key => $value) {
                // Handle attributes for the current element
                
                if ($key === '@attributes') {
                    foreach ($value as $attrKey => $attrValue) {
                        $xmlData->addAttribute($attrKey, $attrValue);
                    }
                } 
                elseif ($key === '@value') {
                    // Handle element values
                    $xmlData[0] = $value;
                } 
                else {
                    if (is_array($value)) {
                        if (is_numeric($key)) {
                            // If the key is numeric, use 'price' for price array, otherwise 'traveldate'
                            if (isset($value['@attributes'])  ) {
                                $key = "traveldate";
                                // $traveldate = 'done';
                            } else {
                                $key = "noooo";
                                $price = true;
                            }
                        }
                        // if($key === 'price'){
                        //     foreach($value as $subkey => $subvalue){
                        //         $subnode = $xmlData->addChild($key);
                        //         $subnode->addAttribute('text', htmlspecialchars($subvalue['@attributes']['text']));
                        //         $subnode[0]= $subvalue['@attributes']['@value'];
                        //     }
                        // }
                        if ($key === 'price') {
                            foreach ($value as $subvalue) {
                                // Create a price node with the @value as its text content
                                $subnode = $xmlData->addChild($key, htmlspecialchars($subvalue['@value']));
                                
                                // Add attributes from @attributes array
                                foreach ($subvalue['@attributes'] as $attrKey => $attrValue) {
                                    $subnode->addAttribute($attrKey, htmlspecialchars($attrValue));
                                }
                            }
                            // break;
                        }
                        if($key !== 'price'){

                            $subnode = $xmlData->addChild($key);
                            arrayToXml($value, $subnode, $traveldate);
                        }
                        // if($key === )
                        // foreach($value['@attributes'] as $subindex1 => $subvalue1){
                        //     $subnode->addAttribute($subindex1, htmlspecialchars($subvalue1));
                        // }
        
                        // Check if we need to add a 'text' attribute
                        // if ($key === "price" && isset($value['@attributes']['text'])) {
                        //     $subnode->addAttribute('text', htmlspecialchars($value['@attributes']['text']));
                        // }
                            
                    } else {
                        // Handle simple key-value pairs
                        $xmlData->addChild($key, htmlspecialchars($value));
                    }
                }
            }
        }
        
        function convertArrayToXml($array, $rootElement = 'root' , $encoded) {
            if($encoded){
                $xml = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><{$rootElement}></{$rootElement}>");
            }
            else{
                $xml = new \SimpleXMLElement("<?xml version=\"1.0\"?><{$rootElement}></{$rootElement}>");

            }
        
            arrayToXml($array, $xml);
        
            $dom = new \DOMDocument();
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
        
            // Load XML string into DOMDocument
            $dom->loadXML($xml->asXML());
            $xpath = new \DOMXPath($dom);
        
            // Normalize text nodes
            foreach ($xpath->query('//text()') as $textNode) {
                // Trim the text and collapse multiple spaces into a single space
                $normalizedText = preg_replace('/\s+/u', ' ', trim($textNode->nodeValue));
                $textNode->nodeValue = $normalizedText;
            }
        
            // Return formatted XML string
            return $dom->saveXML();
        }
        $xml1Encoded = str_contains($xml1, 'encoding="UTF-8"');
        $xml2Encoded = str_contains($xml2, 'encoding="UTF-8"');
        $xmlString1 = convertArrayToXml($keyValueArray_1, 'travelobject',$xml1Encoded); 
        $xmlString2 = convertArrayToXml($keyValueArray_2, 'travelobject',$xml2Encoded); 
        $dateString1 = convertArrayToXml($dates_1, 'traveldates', $xml1Encoded);
        $dateString2 = convertArrayToXml($dates_2, 'traveldates', $xml2Encoded);
        function replaceXml($xmlString,$xmlEncoded){
            if($xmlEncoded){
                return str_replace('<?xml version="1.0" encoding="UTF-8"?>' , '', $xmlString );
            }
            else{
                return str_replace('<?xml version="1.0"?>' , '', $xmlString );
            }
            
        }
        $noxml1 = replaceXml($dateString1,$xml1Encoded);
        $noxml2 = replaceXml($dateString2,$xml2Encoded);
        // array_push($keyValueArray_1,$dates_1);
        // $fullstring1 = convertArrayToXml($keyValueArray_1, 'travelobject',$xml1Encoded);
        function xmlMerge($dateString,$xml ){
            $start_word = "<traveldates>";
            $end_word = "</traveldates>";
    
            // Substring to be added
            $substring_to_add =  $dateString ;
    
            // Create a regex pattern to match from the start word to the end word
            $pattern = '/' . preg_quote($start_word, '/') . '.*?' . preg_quote($end_word, '/') . '/';
    
            // Use preg_replace to replace the matched substring with the new substring
            $final_string = preg_replace($pattern, $substring_to_add, $xml);
    
            
            return $final_string;
            
        }
        $fullstring1 = xmlMerge($noxml1 , $xml1);
        $fullstring2 = xmlMerge($noxml2 , $xml2);

        // function flattenArray($array) {
        //     $flatArray = [];
            
        //     foreach ($array as $value) {
        //         if (is_array($value)) {
        //             // Recursively flatten the array
        //             $flatArray = array_merge($flatArray, flattenArray($value));
        //         } else {
        //             // Add the value to the flat array
        //             $flatArray[] = $value;
        //         }
        //     }
            
        //     return $flatArray;
        // }
        // $flattenedArray1 = flattenArray($keyValueArray_1);
        // $stringArray1 = implode('', $flattenedArray1);        
        // $flattenedArray2 = flattenArray($keyValueArray_2);
        // $stringArray2 = implode('', $flattenedArray2);        
        // dd($xml1parsed, $xml2parsed);
        // dd($xml1, $xml2,$newxml1 ,$newxml2 , $keyValueArray_1, $keyValueArray_2, $xmlString1, $xmlString2);
        
        // dd($xmlString1,$dateString1,$xmlString2, $dateString2);
        // str_contains($xml1,'<traveldates>');
        // dd($fullstring2);
        $this->diff = DiffHelper::calculate(
            $fullstring1,
            $fullstring2,
            'sidebyside',
            $diffOptions,
            $rendererOptions,
        );
    }

    public function render()
    {
        return view('livewire.org.omparator.omparator-form');
    }
}
