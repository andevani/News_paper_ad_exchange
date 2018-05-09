$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");

$img = $_POST['imgBase64'];
$myfile = fopen("n1ewfile.txt", "w") or die("Unable to open file!");

echo $img;
$img = str_replace('data:image/png;base64,', '', $img);

$img = str_replace(' ', '+', $img);

$fileData = base64_decode($img);

//saving

$fileName = 'photo.png';

file_put_contents($fileName, $fileData);
