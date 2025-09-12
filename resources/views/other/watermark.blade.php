<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Watermark Tool</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }
        .container {
            width: 100%;
            max-width: 800px;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #1c1e21;
        }
        .input-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        input[type="file"],
        input[type="text"],
        input[type="color"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            -webkit-appearance: none; /* For color input, to remove default styling */
            -moz-appearance: none;
            appearance: none;
        }
        input[type="color"] {
            padding: 0;
            height: 40px; /* Adjust height for better visual */
            width: 80px; /* Make it smaller */
            vertical-align: middle;
            border: none;
            cursor: pointer;
        }
        input[type="number"] {
            width: auto; /* Allow number input to be smaller */
            max-width: 100px;
            display: inline-block;
        }
        .setting-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .setting-row label {
            margin-bottom: 0;
            white-space: nowrap; /* Prevent label from wrapping */
        }
        button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        button:hover {
            background-color: #0056b3;
        }
        #results {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        .result-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            background-color: #fafafa;
        }
        .result-item img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .result-item a {
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Image Watermark Tool 🖼️</h1>

        <div class="input-group">
            <label for="imageInput">1. Upload Your Images (Multiple Allowed)</label>
            <input type="file" id="imageInput" accept="image/*" multiple>
        </div>

        <div class="input-group">
            <label for="logoInput">2. Upload Watermark Logo</label>
            <input type="file" id="logoInput" accept="image/png, image/jpeg">
        </div>

        <div class="input-group">
            <label for="textInput">3. Enter Watermark Text</label>
            <input type="text" id="textInput" placeholder="e.g., © 2025 Your Name">
        </div>

        <div class="input-group">
            <label>4. Watermark Settings</label>
            <div class="setting-row">
                <label for="textColor">Text Color:</label>
                <input type="color" id="textColor" value="#FFFFFF">
            </div>
            <div class="setting-row">
                <label for="textSize">Text Size (% of Image Width):</label>
                <input type="number" id="textSize" value="2" min="0.5" step="0.5" max="10">
            </div>
            <div class="setting-row">
                <label for="logoSize">Logo Size (% of Image Width):</label>
                <input type="number" id="logoSize" value="12" min="1" step="1" max="50">
            </div>
        </div>

        <button id="processBtn">Apply Watermark & Download</button>

        <div id="results"></div>
    </div>

    <script>
        document.getElementById('processBtn').addEventListener('click', async () => {
            const imageInput = document.getElementById('imageInput');
            const logoInput = document.getElementById('logoInput');
            const textInput = document.getElementById('textInput');
            const resultsDiv = document.getElementById('results');

            const textColorInput = document.getElementById('textColor');
            const textSizeInput = document.getElementById('textSize');
            const logoSizeInput = document.getElementById('logoSize');

            // --- Basic Validation ---
            if (imageInput.files.length === 0) {
                alert('Please upload at least one image.');
                return;
            }
            if (logoInput.files.length === 0) {
                alert('Please upload a logo image.');
                return;
            }

            const watermarkText = textInput.value || '';
            const chosenTextColor = textColorInput.value;
            // Convert percentage to a decimal for calculation (e.g., 2 -> 0.02)
            const chosenTextSizePercentage = parseFloat(textSizeInput.value) / 100;
            const chosenLogoSizePercentage = parseFloat(logoSizeInput.value) / 100;

            if (isNaN(chosenTextSizePercentage) || chosenTextSizePercentage <= 0) {
                alert('Please enter a valid positive number for Text Size.');
                return;
            }
            if (isNaN(chosenLogoSizePercentage) || chosenLogoSizePercentage <= 0) {
                alert('Please enter a valid positive number for Logo Size.');
                return;
            }

            resultsDiv.innerHTML = 'Processing...';

            const logoFile = logoInput.files[0];
            const logo = await loadImage(URL.createObjectURL(logoFile));

            resultsDiv.innerHTML = ''; 
            for (let i = 0; i < imageInput.files.length; i++) {
                const imageFile = imageInput.files[i];
                const originalImage = await loadImage(URL.createObjectURL(imageFile));

                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = originalImage.width;
                canvas.height = originalImage.height;

                // 1. Draw the original image
                ctx.drawImage(originalImage, 0, 0);

                // 2. Draw the watermark logo (TOP-RIGHT)
                // Use the user-defined percentage for logo width
                const logoWidth = canvas.width * chosenLogoSizePercentage; 
                const logoHeight = (logo.height / logo.width) * logoWidth;
                const logoPadding = canvas.width * 0.025; 
                
                const logoX = canvas.width - logoWidth - logoPadding;
                const logoY = logoPadding;
                
                ctx.globalAlpha = 0.8;
                ctx.drawImage(logo, logoX, logoY, logoWidth, logoHeight);
                ctx.globalAlpha = 1.0;

                // 3. Draw the watermark text (BOTTOM-CENTER)
                // Use the user-defined percentage for font size
                const fontSize = canvas.width * chosenTextSizePercentage;
                ctx.font = `bold ${fontSize}px Arial`;
                ctx.fillStyle = chosenTextColor; // Use user-defined color
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';
                const textPadding = canvas.width * 0.02;
                const textX = canvas.width / 2;
                const textY = canvas.height - textPadding;
                ctx.fillText(watermarkText, textX, textY);

                // --- Generate and display the result ---
                const dataUrl = canvas.toDataURL('image/jpeg');
                
                const resultItem = document.createElement('div');
                resultItem.className = 'result-item';

                const previewImg = document.createElement('img');
                previewImg.src = dataUrl;

                const downloadLink = document.createElement('a');
                downloadLink.href = dataUrl;
                const newFileName = `${imageFile.name.split('.').slice(0, -1).join('.')}_watermarked.jpg`;
                downloadLink.download = newFileName;
                downloadLink.textContent = `Download ${newFileName}`;

                resultItem.appendChild(previewImg);
                resultItem.appendChild(downloadLink);
                resultsDiv.appendChild(resultItem);
            }
        });

        // Helper function to load an image and return a promise
        function loadImage(src) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.onload = () => resolve(img);
                img.onerror = reject;
                img.src = src;
            });
        }
    </script>

</body>
</html>