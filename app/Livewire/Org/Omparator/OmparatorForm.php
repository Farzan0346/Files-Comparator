<?php

namespace App\Livewire\Org\Omparator;

use Livewire\Component;
use Livewire\WithFileUploads;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Renderer\RendererConstant;

use function Laravel\Prompts\alert;

class OmparatorForm extends Component
{
    use WithFileUploads;

    public $file1, $file2, $fileType;
    public $diff;

    public function submit()
    {

        $mimeType = $this->fileType;
        // Validate uploaded files
        $this->validate([
            'file1' => 'required|file|mimetypes:' . $mimeType,
            'file2' => 'required|file|mimetypes:' . $mimeType,
            'fileType' => 'required|string'
        ]);
        $file1 = $this->file1;
        $file2 = $this->file2;
    
        // Get MIME types of the files
        $file1MimeType = $file1->getMimeType();
        $file2MimeType = $file2->getMimeType();
        
        if ($file1MimeType === 'text/plain') {
            $textFile1 = file_get_contents($this->file1->getRealPath());
            $textFile2 = file_get_contents($this->file2->getRealPath());
            $file1 = mb_convert_encoding($textFile1, 'UTF-8', 'auto');
            $file2 = mb_convert_encoding($textFile2, 'UTF-8', 'auto');
            // This is a text file
        } elseif ($file1MimeType === 'application/xml' || $file1MimeType === 'text/xml') {

            function normalizeXml($xml) {
                $dom = new \DOMDocument();
                $dom->preserveWhiteSpace = false; // Preserve the original formatting
                $dom->formatOutput = true;
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
            // Xml to Key Value Object
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
            
            // Travel dates sorting
            
            $dates_1 =[];
            $dates_2 =[];
            $found_index_1 = [];
            $found_index_2 = [];
            // dd($keyValueArray_1, $keyValueArray_2, $differences);
            if (array_key_exists('traveldates', $keyValueArray_1) && array_key_exists('traveldates', $keyValueArray_2)) {
                if (array_key_exists('traveldate', $keyValueArray_1['traveldates']) && array_key_exists('traveldate', $keyValueArray_2['traveldates'])) {
                    $dates_1 = $keyValueArray_1['traveldates']['traveldate'];
                    $dates_2 = $keyValueArray_2['traveldates']['traveldate'];
                    unset($keyValueArray_1['traveldates']);
                    unset($keyValueArray_2['traveldates']);
                    if( is_array($dates_1) && is_array($dates_2) ){
                        
                        $attr_1 = [];
                        $attr_2 = [];
                        $found_index =[];
    
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
                                        $found = true;
                                        $found_index[] = $index2;
                                        $found_index_1[] = $index;
                                        $found_index_2[] = $index2;
                                        break;
                                    } 
    
                                }
                                // if(!$found){
    
                                //     $result[] = ['Existed in file 1 but not in file 2' => $dateRange1];
    
                                // }
                        }
                        // foreach($attr_2 as $index2 => $dateRange2){
                            
                        //     if (!in_array($index2, $found_index, true)) {
                        //         // If the index from $attr_2 is not in $found_indices, it means it wasn't matched
                        //         $result[] = ['Existed in file 2 but not in file 1' => $dateRange2];
                        //     }
                        // }
                        $dates1new = [];
                        foreach($found_index_1 as $index1xml => $val1){
                            $temp_index1 = $val1;
                            $dates1new[$index1xml] = $dates_1[$temp_index1];
                            // unset($dates_1[$temp_index1]);
                        }
                        foreach ($dates_1 as $key => $value) {
                            if (!in_array($key, array_values($found_index_1))) {
                                $dates1new[] = $value; // Append remaining values to the end of $dates2new
                            }
                        }
                        $dates2new = [];
                        foreach($found_index_2 as $index2Xml => $val2){
                            $temp_index = $val2;
                            $dates2new[$index2Xml] = $dates_2[$temp_index];
                            // unset($dates_2[$temp_index]);
    
                        }
                        foreach ($dates_2 as $key => $value) {
                            if (!in_array($key, array_values($found_index_2))) {
                                $dates2new[] = $value; // Append remaining values to the end of $dates2new
                            }
                        }
                        // foreach($found_index_2 as $index2Xml => $temp_index) {
                        //     $value_to_move = $dates_2[$temp_index];
                            
                        //     // Remove the element from its original position
                        //     unset($dates_2[$temp_index]);
                        
                        //     // Insert the element at the desired position
                        //     array_splice($dates_2, $index2Xml, 0, $value_to_move);
                        
                        //     // Optionally, reset array keys if needed
                        //     $dates_2 = array_values($dates_2);
                        // }
                        // dd(count($found_index_2 ), count($dates_2));
                    }
                }
            }
            
    
            $xml1Content = file_get_contents($this->file1->getRealPath());
            $xml2Content = file_get_contents($this->file2->getRealPath());
            // $xml1 = normalizeXml($xml1Content);
            // $xml2 = normalizeXml($xml2Content);
            $xml1 = file_get_contents($this->file1->getRealPath());
            $xml2 = file_get_contents($this->file2->getRealPath());
            
            // dd(str_replace('<traveldates>' , 'helloooo', $xml1 ));
            
            // Converting array to xml
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
            $dateString1 = convertArrayToXml($dates1new, 'traveldates', $xml1Encoded);
            $dateString2 = convertArrayToXml($dates2new, 'traveldates', $xml2Encoded);
            // arrayToXml($dates_1, $xml1converted);
            // arrayToXml($dates_2, $xml2converted);
            // dd($xml1converted);
            // dd(gettype($dates_1));
            // $dateString1 = implode(' ',$xml1converted);
            // $dateString2 = implode(' ',$xml2converted);
            // dd(gettype($dateString1));
            // Xml encoding
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
    
            // Marging xml content together
            function xmlMerge($dateString,$xml ){
                $start_word = "<traveldates>";
                $end_word = "</traveldates>";
        
                // Substring to be added
                $substring_to_add =  $dateString ;
        
                // Create a regex pattern to match from the start word to the end word
                $pattern = '/(?<=' . preg_quote($start_word, '/') . ')(.*?)(?=' . preg_quote($end_word, '/') . ')/s';
        
                // Use preg_replace to replace the matched substring with the new substring
                $final_string = preg_replace($pattern, $substring_to_add, $xml);
        
                
                return $final_string;
                
            }
            // dd($noxml1,$noxml2);
            $file1 = normalizeXml(xmlMerge($noxml1 , $xml1));
            $file2 = normalizeXml(xmlMerge($noxml2 , $xml2));
            

            // This is an XML file
        } elseif ($file1MimeType === 'application/json') {
            // This is a JSON file
            // dd(file_get_contents($this->file1->getRealPath()));
            $json1= file_get_contents($this->file1->getRealPath());
            $json2= file_get_contents($this->file2->getRealPath());
            $data1 = json_decode($json1, true);
            $data2 = json_decode($json2, true);
            // $file1 = 
            // $file2 = file_get_contents($this->file2->getRealPath());
            function sortJsonData($data)
            {
                if (is_array($data)) {
                    ksort($data);
                    foreach ($data as &$value) {
                        if (is_array($value) || is_object($value)) {
                            $value = sortJsonData($value);
                        }
                    }
                } elseif (is_object($data)) {
                    $data = (array) $data;
                    ksort($data);
                    foreach ($data as &$value) {
                        if (is_array($value) || is_object($value)) {
                            $value = sortJsonData($value);
                        }
                    }
                    $data = (object) $data;
                }
                return $data;
            }
            $sortedData1 = sortJsonData($data1);
            $sortedData2 = sortJsonData($data2);
            $file1 = json_encode($sortedData1,JSON_PRETTY_PRINT);
            $file2 = json_encode($sortedData2,JSON_PRETTY_PRINT);
            // $file1 = '$sortedData1';
            // $file2 = '$sortedData2';
            // dd($file1, $sortedData1);
        }
        // Normalize xml
        
        // options for Diff class
        $diffOptions = [
            'context' => 1,
            'ignoreCase' => false,
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
        // dd($file1, $file2);
        $this->diff = DiffHelper::calculate(
            $file1,
            $file2,
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
