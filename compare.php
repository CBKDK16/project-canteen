<?php

    // Function to preprocess text
    function preprocess($text) {
        // Implement text preprocessing steps here
        // Convert to lowercase, remove punctuation, tokenize, etc.
        
        // Convert text to lowercase
        $text = strtolower($text);

        // Remove punctuation and special characters
        $text = preg_replace("/[^a-zA-Z0-9\s]/", "", $text);

        // Tokenize the text into individual words
        $words = preg_split("/\s+/", $text);

        // Remove stop words (optional)
        $stopWords = ["the", "and", "or", "a", "an"]; // Example stop words
        $words = array_diff($words, $stopWords);

        // Perform stemming or lemmatization (optional)
        // Implement stemming or lemmatization here if needed

        // Return the preprocessed text as a string
        $preprocessedText = implode(" ", $words);

        return $preprocessedText;
    }

    // Function to compute term frequency (TF) vector
    function computeTF($text) {
        // Tokenize the text into individual words
        $words = preg_split("/\s+/", $text);

        // Count word frequencies
        $wordCount = array_count_values($words);

        // Normalize term frequencies
        $totalWords = count($words);
        $tfVector = [];

        foreach ($wordCount as $word => $count) {
            $tfVector[$word] = $count / $totalWords;
        }

        return $tfVector;
    }

    // Function to compute cosine similarity
    function computeCosineSimilarity($tfVector1, $tfVector2) {
        $dotProduct = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        $terms = array_keys($tfVector1 + $tfVector2);
        print_r($tfVector2);
        // Compute dot product and magnitudes
        foreach ($terms as $term) {
            $v1 = $tfVector1[$term];
            $v2 = $tfVector2[$term];
            $dotProduct += $v1 * $v2;
            print_r($dotProduct);
            echo "<br>";
            $magnitude1 += $v1 * 2;
            $magnitude2 += $v2 * 2;
        }

        $magnitude1 = sqrt($magnitude1);
        $magnitude2 = sqrt($magnitude2);

        print_r($magnitude1);
        echo "<br>";
        print_r($magnitude2);
        echo "<br>";
        // Compute cosine similarity
        $cosineSimilarity = $dotProduct / ($magnitude1 * $magnitude2);
        return $cosineSimilarity;
    }

    // Retrieve documents from the form
    $document1 = $_POST['document1'];
    $document2 = $_POST['document2'];

    // Preprocess the text
    $preprocessedText1 = preprocess($document1);
    $preprocessedText2 = preprocess($document2);

    // Compute term frequency (TF) vectors
    $tfVector1 = computeTF($preprocessedText1);
    $tfVector2 = computeTF($preprocessedText2);

    print_r($tfVector1);
    echo "<br>";
    print_r($tfVector2);
    echo "<br>";

    // Compute cosine similarity
    $cosineSimilarity = computeCosineSimilarity($tfVector1, $tfVector2);

    // Recommendation logic based on cosine similarity
    if ($cosineSimilarity > 0.9) {
        $recommendation = "The documents are highly similar.";
    } 
    elseif ($cosineSimilarity > 0.6) {
        $recommendation = "The documents are moderately similar.";
    } 
    else {
        $recommendation = "The documents are not very similar.";
        echo "<p>Cosine Similarity: " . $cosineSimilarity . "</p>";
    }

    // Display the results
    echo "<h1>Comparison Results</h1>";
    echo "<p>Cosine Similarity: " . $cosineSimilarity . "</p>";
    echo "<p>Recommendation: " . $recommendation . "</p>";

?>
