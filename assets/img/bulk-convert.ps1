# Get all PNG images in the current directory & convert it to WebP format
$rootDirectory = Get-Location

# Get all PNG files in the root directory and its subdirectories
$pngFiles = Get-ChildItem -Path $rootDirectory -Filter *.png -Recurse

# Check if there are any PNG files
if ($pngFiles.Count -eq 0) {
    Write-Host "No PNG images found in the specified directory and its subdirectories."
    exit
}

foreach ($pngFile in $pngFiles) {
    $webpFilePath = [System.IO.Path]::ChangeExtension($pngFile.FullName, ".webp")

    # Convert PNG to WebP
    Start-Process -FilePath 'cwebp.exe' -ArgumentList "-q", "80", "$($pngFile.FullName)", "-o", "$webpFilePath" -Wait

    # Remove original PNG file after conversion
    Remove-Item $pngFile.FullName -Force
}

Write-Host "Conversion complete."
