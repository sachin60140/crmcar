<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator with Adjustable Icon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        #qr-code-container {
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            min-height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative; /* Crucial for positioning the icon */
        }
        #qrcode {
            display: inline-block;
        }
        /* Style for the Font Awesome icon */
        .qr-social-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #333; /* Default icon color */
            background-color: white;
            /* Using 'em' units makes padding and radius scale with the font-size */
            padding: 0.15em; 
            border-radius: 0.2em;
            box-shadow: 0 0 8px rgba(0,0,0,0.3); /* Subtle shadow for depth */
            display: flex; 
            align-items: center;
            justify-content: center;
        }
        /* Specific brand colors for social icons */
        .qr-social-icon.fa-facebook { color: #1877F2; }
        .qr-social-icon.fa-twitter { color: #1DA1F2; }
        .qr-social-icon.fa-instagram { color: #E4405F; }
        .qr-social-icon.fa-linkedin { color: #0A66C2; }
        .qr-social-icon.fa-youtube { color: #FF0000; }
        .qr-social-icon.fa-github { color: #181717; }
        .qr-social-icon.fa-whatsapp { color: #25D366; }

        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h3>QR Code Generator with Adjustable Icon 🎨</h3>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="qr-text" class="form-label">Enter Text or URL</label>
                <input type="text" class="form-control" id="qr-text" value="https://www.google.com" placeholder="e.g., https://www.example.com">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="qr-size" class="form-label">QR Code Size (px)</label>
                    <select class="form-select" id="qr-size">
                        <option value="128">128x128</option>
                        <option value="256" selected>256x256</option>
                        <option value="512">512x512</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="qr-correction" class="form-label">Error Correction</label>
                    <select class="form-select" id="qr-correction">
                        <option value="L">Low (L)</option>
                        <option value="M">Medium (M)</option>
                        <option value="Q">Quartile (Q)</option>
                        <option value="H" selected>High (H) - Best for icons</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="social-icon-select" class="form-label">Social Media Icon</label>
                    <select class="form-select" id="social-icon-select">
                        <option value="">-- No Icon --</option>
                        <option value="fab fa-facebook">Facebook</option>
                        <option value="fab fa-twitter">X (Twitter)</option>
                        <option value="fab fa-instagram">Instagram</option>
                        <option value="fab fa-linkedin">LinkedIn</option>
                        <option value="fab fa-youtube">YouTube</option>
                        <option value="fab fa-whatsapp">WhatsApp</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="icon-size-select" class="form-label">Icon Size</label>
                    <select class="form-select" id="icon-size-select">
                        <option value="15">Small (15%)</option>
                        <option value="20" selected>Medium (20%)</option>
                        <option value="25">Large (25%)</option>
                        <option value="30">Extra Large (30%)</option>
                    </select>
                </div>
            </div>

            <div class="d-grid">
                <button id="generate-btn" class="btn btn-success">Generate QR Code</button>
            </div>
            
            <hr>

            <div id="qr-code-container">
                <p class="text-muted">Your QR Code will appear here</p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

<script>
$(document).ready(function() {
    let qrcode = null; // To hold the QRCode.js instance

    function generateQrCode() {
        // Clear previous QR code and icon
        $("#qr-code-container").empty(); 

        let qrText = $("#qr-text").val();
        if (!qrText) {
            $("#qr-code-container").html('<p class="text-danger">Please enter text or a URL.</p>');
            return;
        }

        let qrSize = parseInt($("#qr-size").val());
        let qrCorrection = $("#qr-correction").val();
        
        // --- Create containers for QR code and Icon ---
        let qrWrapper = $('<div id="qrcode"></div>');
        $("#qr-code-container").append(qrWrapper);

        // --- Generate the QR Code ---
        qrcode = new QRCode(document.getElementById("qrcode"), {
            text: qrText,
            width: qrSize,
            height: qrSize,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel[qrCorrection]
        });

        // --- Handle Social Media Icon Overlay ---
        let selectedIconClass = $("#social-icon-select").val();
        if (selectedIconClass) {
            let iconSizePercent = parseInt($("#icon-size-select").val());
            // Calculate the icon's font size in pixels based on the QR code's size
            let iconPixelSize = qrSize * (iconSizePercent / 100);

            // Create the icon element
            let socialIcon = $('<i>', {
                class: 'qr-social-icon ' + selectedIconClass
            });
            
            // Apply the calculated size directly to the element's style
            socialIcon.css('font-size', iconPixelSize + 'px');
            
            $("#qr-code-container").append(socialIcon);
        }
    }

    // --- Event Listener ---
    $("#generate-btn").on("click", function() {
        generateQrCode();
    });

    // Generate a default QR code on page load
    generateQrCode(); 
});
</script>

</body>
</html>