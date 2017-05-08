<script>
        window.location.href = 'index.php';
</script>

<?php


include_once "../../../../vendor/autoload.php";

use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

if(isset($_POST["Import"])){

    $filename=$_FILES["file"]["tmp_name"];


    if($_FILES["file"]["size"] > 0)
    {
        $file = fopen($filename, "r");
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
        {


            $pdo = new PDO('mysql:host=localhost;dbname=tweets', 'root', '');
            $pdo->query('CREATE TABLE IF NOT EXISTS tweets (`user` VARCHAR(255), tweet VARCHAR(255))');

            $config = new LexerConfig();
            $lexer = new Lexer($config);

            $interpreter = new Interpreter();

            $interpreter->addObserver(function(array $columns) use ($pdo) {
                $stmt = $pdo->prepare('REPLACE tweets (user, tweet) VALUES (?, ?)');
                $stmt->execute($columns);
            });

            $lexer->parse($filename, $interpreter);
            if(!isset($result))
            {
                echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"index.php\"
						  </script>";
            }
            else {
                echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"index.php\"
					</script>";
            }
        }

        fclose($file);
    }
}
?>



