<?php
// Function to preprocess text
    function preprocess($text) { 
        // Implement text preprocessing steps here
        // Convert to lowercase, remove punctuation, tokenize, etc.
        
        // Convert text to lowercase
        $text = strtolower($text);

        // Remove punctuation and special characters
        $text = preg_replace("/[^a-zA-Z0-9\s]/", "", $text);

        // echo "<br/><pre> text from user  <br/><br/> ";
        // print_r($text);

        // Tokenize the text into individual words
        $words = preg_split("/\s+/", $text);

        // Remove stop words (optional)
        $stopWords = ["the", "and", "is" , "or", "a", "an"]; // Example stop words
        $words = array_diff($words, $stopWords);

        return $words;
    }

    // Function to compute term frequency (TF) vector
    function computeTF($text) {
        $words = $text;
        // Count word frequencies
        $wordCount = array_count_values($words);

        // echo '<br/> <br/> wordcount   <br/> ';
        // print_r($wordCount);

        // Normalize term frequencies
        $totalWords = count($words);

        // echo '<br/> <br/> totalWords   <br/> ';
        // print_r($totalWords);

        $tfVector = [];

        foreach ($wordCount as $word => $count) {
            $tfVector[$word] = $count / $totalWords;

            // echo '<br/> <br/> tfvector  <br/> ';
            // print_r($tfVector[$word]);
        }

        return $tfVector;
    }

    // Function to compute cosine similarity
    function computeCosineSimilarity($vector1, $vector2) {
        $dotProduct = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        // Compute dot product and magnitudes
        foreach ($vector1 as $term => $value) {
            if (isset($vector2[$term])) {
                $dotProduct += $vector1[$term] * $vector2[$term];
            }
            $magnitude1 += $vector1[$term] ** 2;
        }

        foreach ($vector2 as $term => $value) {
            $magnitude2 += $vector2[$term] ** 2;
        }

        // Compute cosine similarity
        $similarity = 0;
        if ($magnitude1 > 0 && $magnitude2 > 0) {
            $similarity = $dotProduct / (sqrt($magnitude1) * sqrt($magnitude2));
        }

        return $similarity;
    }
    function array_push_assoc($array, $key, $value)
    {
       $array[$key] = $value;
       return $array;
    }
?>