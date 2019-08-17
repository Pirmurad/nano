<?PHP

// replace with ip address or hostname
$host = '217.64.27.46';

// replace with your private API url
$url = 'http://www.ipaddressapi.com/l/7af7e383dde4ea127dcaa68b21d97f0f081441d2971c?h=' . urlencode ($host);

$curl = curl_init ()
or die ('curl_init() failed');

curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt ($curl, CURLOPT_TIMEOUT, 5);
curl_setopt ($curl, CURLOPT_URL, $url);
$data = curl_exec ($curl);
curl_close ($curl);

if ($data === false)
{
die ('curl_exec() failed');
}
else if ($data === '')
{
die ('empty result');
}

// parse result into array
$fields = explode (',', str_replace('"', '', $data));

echo '<pre>' . print_r($fields, true) . '</pre>';