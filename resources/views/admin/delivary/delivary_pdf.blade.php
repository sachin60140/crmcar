<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car4Sales | Vehicle Delivery Slip & Invoice</title>
    <style>
        /* RESET & BASE - OPTIMIZED FOR 2-PAGE PRINT */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Segoe UI', 'Roboto', 'Arial', sans-serif;
            background: #e2e8f0;
            padding: 0;
            margin: 0;
            color: #000000;
        }

        /* A4 SIZE CONTAINER - EXACT DIMENSIONS */
        .invoice-wrapper {
            max-width: 210mm;
            width: 100%;
            margin: 0 auto;
            background: white;
        }

        /* PAGE STYLING - OPTIMIZED FOR 2 PAGES */
        .page {
            padding: 10mm 12mm;
            background: white;
            height: auto;
            min-height: 277mm;
            /* A4 height approx */
            page-break-after: avoid;
        }

        .page-break {
            page-break-before: always;
        }

        /* HEADER SECTION - WITH LOGO */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo img {
            width: 175px;
            height: auto;
            display: block;
        }

        .company h1 {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }

        .company p {
            font-size: 9px;
            line-height: 1.3;
            color: #000000;
        }

        /* MAIN TITLE */
        .main-title {
            text-align: center;
            font-size: 18px;
            font-weight: 800;
            margin: 3px 0 5px;
            letter-spacing: 1px;
        }

        .main-title:after {
            content: "";
            display: block;
            width: 60px;
            height: 2px;
            background: #000;
            margin: 6px auto 0;
        }

        /* SECTION TITLES - COMPACT */
        .section-title {
            background: #f4f4f4;
            border-left: 4px solid #000;
            padding: 5px 12px;
            font-weight: 800;
            font-size: 12px;
            margin: 8px 0 5px 0;
            border: 1px solid #ddd;
            border-left: 4px solid #000;
        }

        /* INFO TABLES - COMPACT */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3px;
            font-size: 10px;
        }

        .info-table td,
        .info-table th {
            padding: 5px 4px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: top;
        }

        .info-table .label {
            font-weight: 700;
            width: 120px;
            background: #fafafa;
            font-size: 10px;
        }

        .info-table .value {
            font-weight: 500;
            font-size: 10px;
        }

        /* CHECKLIST TABLE - COMPACT */
        .checklist-table {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0;
            font-size: 10px;
        }

        .checklist-table th {
            background: #f0f0f0;
            font-weight: 800;
            padding: 6px 6px;
            border: 1px solid #000;
            text-align: left;
            font-size: 10px;
        }

        .checklist-table td {
            border: 1px solid #000;
            padding: 5px 6px;
            vertical-align: top;
            font-size: 10px;
        }

        /* SIGNATURE SECTION - FORCED SINGLE ROW */
        .signatures {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            margin-top: 40px;
            /* Increased to give space to sign */
            flex-wrap: nowrap;
            /* Forces items into a single row */
        }

        .sign-box {
            flex: 1;
            text-align: center;
        }


        .sign-note {
            font-size: 8px;
            margin-top: 3px;
            color: #555;
        }

        /* FOOTER */
        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 8px;
            background: #f9f9f9;
            padding: 5px;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }

        /* AGREEMENT PAGE */
        .agreement-title {
            text-align: center;
            font-size: 12px;
            font-weight: 800;
            margin: 500px 0 5px;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .terms-box {

            padding: 3px 5px;
            background: #fff;
        }

        .intro-text {
            font-size: 9.5px;
            margin-bottom: 12px;
            line-height: 1.5;
            text-align: justify;
        }

        /* ORDERED AND UNORDERED LIST FOR TERMS */
        .terms-list {
            margin-left: 10px;
            font-size: 8px;
            line-height: 1.1;
            text-align: justify;
        }

        .terms-list li {
            margin-bottom: 10px;
            padding-left: 5px;
        }

        .terms-list li strong {
            font-weight: 800;
            font-size: 8px;
            display: inline-block;
            margin-bottom: 2px;
        }

        .terms-list ul {
            margin-top: 2px;
            margin-left: 15px;
            list-style-type: disc;
            /* Bullet points */
        }

        .terms-list ul li {
            margin-bottom: 4px;
            font-weight: 700;
        }

        /* PRINT OPTIMIZATION - EXACT 2 PAGES */
        @media print {
            @page {
                size: A4;
                margin: 10mm 8mm;
            }

            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .invoice-wrapper {
                box-shadow: none;
                max-width: 100%;
            }

            .page {
                padding: 0;
                page-break-after: avoid;
                page-break-inside: avoid;
            }

            .page-break {
                page-break-before: always;
            }

            .section-title,
            .checklist-table th {
                background: #f0f0f0 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

        }

        /* RESPONSIVE */
        @media (max-width: 700px) {
            .page {
                padding: 10px;
            }

            .header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .header-left {
                flex-direction: column;
            }

            .signatures {
                flex-direction: column;
                gap: 40px;
            }
        }

        /* Header Section - Using Table */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            border-bottom: 2px solid #000;
            padding-bottom: 7px;
        }

        .header-table td {
            vertical-align: top;
            padding: 5px;
        }

        .company-cell {
            width: 60%;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #000;
            margin-bottom: 8px;
        }

        .company-details {
            font-size: 10px;
            color: #000000;
            line-height: 1.4;
        }

        .invoice-cell {
            width: 40%;
            text-align: right;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
        }

        /* Signature Section */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0 20px;

            padding-top: 20px;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            padding-top: 20px;
            vertical-align: bottom;
        }

        .sign-line {
            border-bottom: 1px solid #888;
            width: 80%;
            margin: 8px auto 5px;
            font-weight: 700;
            font-size: 9px;
        }

        .sign-date {
            font-size: 9px;
            color: #000000;
        }
    </style>
</head>

<body>
    <div class="invoice-wrapper">
        <div class="page">
            
            <table class="header-table">
                <tr>
                    <td class="company-cell">
                        <div class="logo">
                            <img src="assets/img/logotrans.png" width="175px">
                        </div>
                        {{-- <div class="company-name">AMISHEK CAR4SALES TRADING PRIVATE LIMITED</div> --}}
                        <div class="company-details">
                            AMISHEK CAR4SALES TRADING PRIVATE LIMITED<br>
                            CIN: U45102BR2025PTC078595 | GST: 10ABDCA6650P1ZL<br>
                            Chandani Chowk, MBBL Collage, Damodarpur, Muzaffarpur,Bihar 843113 <br>
                            Tel: +91 777 999 5656
                        </div>
                    </td>
                    <td class="invoice-cell">
                        <div class="invoice-title">Delivery Slip</div>
                        <div style="width: 100%; text-align: right; margin-top: 10px;">
                            <div
                                style="display: inline-block; border: 1.5px solid #000; padding: 10px 12px; border-radius: 6px; text-align: center; background-color: #fff;">
                                <div>
                                    {!! DNS1D::getBarcodeHTML('C4S' . str_pad($getRecords[0]['id'], 6, '0', STR_PAD_LEFT), 'C128', 1.2, 40) !!}
                                </div>
                                <div style="margin-top: 6px; font-size: 12px; font-weight: bold; letter-spacing: 1px;">
                                    C4S{{ str_pad($getRecords[0]['id'], 6, '0', STR_PAD_LEFT) }}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="main-title">VEHICLE DELIVERY SLIP</div>

            <div class="section-title"> DELIVERY BRANCH</div>
            <table class="info-table">
                <tr>
                    <td class="label">Branch Name</td>
                    <td class="value"><strong>{{ $getRecords[0]['branch'] }}</strong></td>
                    <td class="label">Sales Person</td>
                    <td class="value"><strong>{{ $getRecords[0]['booking_person'] }}</strong></td>
                </tr>
            </table>

            <div class="section-title"> CUSTOMER INFORMATION</div>
            <table class="info-table">
                <tr>
                    <td class="label">Customer Name</td>
                    <td class="value"><strong>{{ $getRecords[0]['name'] }}</strong></td>
                    <td class="label">Father's Name</td>
                    <td class="value">{{ $getRecords[0]['father_name'] }}</td>

                </tr>
                <tr>
                    <td class="label">Mobile Number</td>
                    <td>{{ $getRecords[0]['mobile'] }}</td>
                    <td class="label">Aadhaar No</td>
                    <td>{{ $getRecords[0]['aadhar'] }}</td>

                </tr>
                <tr>
                    <td class="label">PAN No</td>
                    <td>{{ $getRecords[0]['pan_card'] }}</td>
                    <td class="label">Delivery Date & Time</td>
                    <td><strong>{{ date('d/m/Y h:i A', strtotime($getRecords[0]['created_at'])) }}</strong></td>
                </tr>

                <tr>
                    <td class="label">Residential Address</td>
                    <td colspan="5">{{ $getRecords[0]['address'] }}</td>
                </tr>
            </table>

            <div class="section-title"> VEHICLE SPECIFICATIONS</div>
            <table class="info-table">
                <tr>
                    <td class="label">Registration No</td>
                    <td><strong>{{ $getRecords[0]['reg_number'] }}</strong></td>
                    <td class="label">Car Model</td>
                    <td>{{ $getRecords[0]['model_name'] }}</td>
                    <td class="label">Owner Serial No.</td>
                    <td>{{ $getRecords[0]['owner_sl_no'] }}</td>
                </tr>
                <tr>
                    <td class="label">Chassis No</td>
                    <td>{{ $getRecords[0]['chassis_number'] }}</td>
                    <td class="label">Engine No</td>
                    <td>{{ $getRecords[0]['eng_number'] }}</td>
                    <td class="label">Color</td>
                    <td>{{ $getRecords[0]['car_color'] }}</td>
                </tr>
            </table>

            <div class="section-title">PRICE & PAYMENT SUMMARY</div>
            <table class="info-table">
                <tr>
                    <td class="label">Vehicle Price</td>
                    <td>₹ {{ $getRecords[0]['sell_amount'] }}</td>
                    <td class="label">Booking Amount</td>
                    <td>₹ {{ $getRecords[0]['booking_amount'] }}</td>
                    <td class="label">Loan Amount</td>
                    <td>₹ {{ $getRecords[0]['finance_amount'] }}</td>
                </tr>
                <tr>
                    <td class="label">Down Payment</td>
                    <td>₹ {{ $getRecords[0]['dp'] }}</td>
                    <td class="label">Payment Mode</td>
                    <td>{{ $getRecords[0]['paymentMode'] }}</td>
                    <td class="label">Financer Name</td>
                    <td>{{ $getRecords[0]['financer'] }}</td>
                </tr>
                <tr>
                    <td class="label">Remarks</td>
                    <td colspan="5">{{ $getRecords[0]['remarks'] }}</td>
                </tr>
            </table>

            <div class="section-title"> DELIVERY CHECKLIST</div>
            <table class="checklist-table">
                <thead>
                    <tr>
                        <th style="width:45%">ITEM DESCRIPTION</th>
                        <th style="width:20%">STATUS</th>
                        <th style="width:35%">REMARKS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>RC Copy</strong></td>
                        <td>✓ Given</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong>Insurance Policy</strong></td>
                        <td>✓ Provided</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong>Pollution</strong></td>
                        <td>✓ Provided</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong>Car Keys</strong></td>
                        <td>✓ Handed</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong>Tool Kit & Jack</strong></td>
                        <td>✓ Complete</td>
                        <td>Spare wheel present</td>
                    </tr>
                </tbody>
            </table>

            {{-- <div class="signatures">
            <div class="sign-box">
                <div class="sign-line">CUSTOMER / BUYER SIGNATURE</div>
                <div class="sign-note">(Delivery acceptance)</div>
            </div>
            <div class="sign-box">
                <div class="sign-line">AUTHORIZED DEALER SIGNATORY</div>
                <div class="sign-note">Car4Sales Pvt Ltd</div>
            </div>
        </div> --}}
            <table class="signature-table">
                <tr>
                    <td>
                        <div class="sign-line">CUSTOMER / BUYER SIGNATURE</div>
                        <div class="sign-date">(Delivery acceptance)</div>
                    </td>
                    <td>
                        <div class="sign-line">Authorized Signatory</div>
                        <div class="sign-date">For AMISHEK CAR4SALES TRADING PRIVATE LIMITED</div>
                    </td>
                </tr>
            </table>

            <div class="footer">
                Delivery Branch: {{ $getRecords[0]['branch'] }} | Slip generated:
                <strong>{{ date('d/m/Y h:i A', strtotime($getRecords[0]['created_at'])) }}</strong> | E. & O.E
            </div>
        </div>

        <div class="page-break"></div>

        <div class="page" >
            <div>

                <div class="agreement-title">VEHICLE SALE AGREEMENT & TERMS OF TRANSFER</div>

                <div class="terms-box">
                    <div class="intro-text">
                        This <strong>Sale cum Delivery Agreement</strong> is executed on this
                        <strong>{{ date('d/m/Y H:i A', strtotime($getRecords[0]['created_at'])) }}</strong>
                        between <strong>AMISHEK CAR4SALES TRADING PRIVATE LIMITED (Seller)</strong> and
                        <strong>{{ $getRecords[0]['name'] }}</strong> S/o Shri <strong>{{ $getRecords[0]['father_name'] }}</strong>, Address: <strong>{{ $getRecords[0]['address']}}</strong> , Aadhar Number:
                    <strong>{{ $getRecords[0]['aadhar'] }}</strong>, PAN: <strong>{{ $getRecords[0]['pan_card'] }}</strong>, (Purchaser) 
                        for the vehicle described as <strong>{{ $getRecords[0]['model_name'] }}, </strong> bearing
                        Registration No:
                        <strong>{{ $getRecords[0]['reg_number'] }}</strong>. Delivery shall be effective from
                        <strong>{{ date('d/m/Y H:i A', strtotime($getRecords[0]['created_at'])) }}</strong> at
                        <strong>{{ $getRecords[0]['branch'] }}</strong>.
                    </div>

                    <ul class="terms-list">
                        <li>
                            The original Registration Certificate (RC) will be transferred to purchaser's name by the
                            respective RTO/DTO. The dealer acts only as facilitator; any delay or liability from
                            transport
                            authority is not attributable to the seller.
                        </li>
                        <li>
                            Insurance is transferred in the name of purchaser after RC transfer. Until then, buyer is
                            advised to maintain comprehensive coverage. Any accident or challan post delivery time is
                            buyer's sole responsibility.
                        </li>
                        <li>
                            The vehicle is sold on AS-IS WHERE-IS basis with complete pre-delivery
                            inspection (PDI) performed. Buyer has inspected the vehicle and finds it satisfactory. No
                            claim
                            regarding mechanical, electrical, or cosmetic aspects shall be entertained after handing
                            over
                            the keys and signed delivery slip.
                        </li>
                        <li>
                            All traffic challans, e-challans or pending fines arising after the delivery timestamp shall
                            be
                            cleared by buyer. Payment made towards the vehicle is non-refundable unless specified in
                            separate agreement. Any legal dispute shall be subject to Muzaffarpur,
                                Bihar
                            jurisdiction only.
                        </li>
                        <li>
                            The delivery checklist is an integral part of this agreement. By signing below, the buyer
                            acknowledges receipt of the vehicle along with all accessories, keys, and documents as per
                            the checklist. Any discrepancy must be reported within 24 hours of delivery; otherwise, the
                            delivery is deemed complete and accepted by the buyer.
                            <ul>
                                <li>✔ I/We acknowledge receipt of vehicle along with all accessories, keys, and
                                    documents
                                    mentioned in the delivery checklist.</li>
                            </ul>
                        </li>
                    </ul>
                </div>


                <table class="signature-table">
                    <tr>
                        <td>
                            <div class="sign-line">CUSTOMER / BUYER SIGNATURE</div>
                            <div class="sign-date">(Delivery acceptance)</div>
                        </td>
                        <td>
                            <div class="sign-line">Authorized Signatory</div>
                            <div class="sign-date">For AMISHEK CAR4SALES TRADING PRIVATE LIMITED</div>
                        </td>
                    </tr>
                </table>

                <div class="footer" style="margin-top: 15px;">
                    This is a computer generated invoice cum agreement — valid without physical signature subject to
                    delivery acknowledgment.
                </div>
            </div>
        </div>
    </div>
</body>

</html>
