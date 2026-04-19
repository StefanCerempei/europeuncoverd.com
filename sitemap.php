<?php
header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Homepage -->
    <url>
        <loc>https://europeuncovered.com/</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

<?php
// Conectare DB
$conn = new mysqli("localhost", "u445817632_username", "Stefan30052006.", "u445817632_europetravel");

if ($conn->connect_error) {
    // opțional: poți loga eroarea
    die("<!-- DB connection failed -->");
}

// Pagini țări
$result = $conn->query("SELECT slug FROM countries");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $slug = htmlspecialchars($row['slug']);
        echo "
    <url>
        <loc>https://europeuncovered.com/country/$slug</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>";
    }
}

$conn->close();
?>
</urlset>
