<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anishek Cars | Booking Invoice</title>
    <style>
        /* Reset and Base Styles - Optimized for DomPDF */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Arial', 'Helvetica', sans-serif;
            background: white;
            font-size: 12px;
            line-height: 1.4;
            color: #000000;
            padding: 20px;
        }

        /* Main Container */
        .invoice {
            max-width: 1100px;
            margin: 0 auto;
            background: white;
        }

        /* Page Break */
        .page-break {
            page-break-before: always;
            margin-top: 20px;
        }

        /* Header Section - Using Table */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .header-table td {
            vertical-align: top;
            padding: 5px;
        }

        .company-cell {
            width: 60%;
        }

        .invoice-cell {
            width: 40%;
            text-align: right;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #000;
            margin-bottom: 8px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 5px;
        }

        .company-details {
            font-size: 10px;
            color: #000000;
            line-height: 1.4;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
        }

        .invoice-meta {
            background: #f5f5f5;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 11px;
            text-align: right;
        }

        .invoice-meta p {
            margin: 2px 0;
        }

        /* Section Title */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #000;
            border-left: 3px solid #000;
            padding-left: 10px;
            margin: 5px 0 5px 0;
        }

        /* Info Table - For all details sections */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
            margin-bottom: 5px;
        }

        .info-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        .info-table .label-cell {
            width: 90px;
            font-weight: 600;
            background: #f9f9f9;
            color: #000000;
        }

        .info-table .value-cell {
            color: #000000;
        }

        .info-table tr:last-child td {
            border-bottom: none;
        }

        /* Full Width Row */
        .full-width-row td {
            padding: 8px 10px;
        }

        .full-width-row .label-cell {
            width: 90px;
            vertical-align: top;
        }

        /* Vehicle Table */
        .vehicle-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .vehicle-table th {
            background: #f5f5f5;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }

        .vehicle-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            font-size: 11px;
        }

        .vehicle-table tr:last-child td {
            border-bottom: none;
        }

        .reg-badge {
            background: #f0f0f0;
            padding: 2px 6px;
            font-family: monospace;
            font-size: 10px;
        }

        /* Payment Section - Two Column Layout */
        .payment-wrapper {
            width: 100%;
            margin: 20px 0;
        }

        .payment-left {
            width: 60%;
            float: left;
        }

        .payment-right {
            width: 35%;
            float: right;
            text-align: right;
        }

        .clearfix {
            clear: both;
        }

        /* Amount Table */
        .amount-table {
            width: 100%;
            max-width: 380px;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }

        .amount-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #eee;
        }

        .amount-table td:first-child {
            font-weight: 500;
            color: #000000;
        }

        .amount-table td:last-child {
            text-align: right;
            font-weight: 600;
        }

        .amount-table .total-row td {
            border-top: 2px solid #000;
            border-bottom: none;
            font-weight: bold;
            font-size: 12px;
            color: #000;
        }

        .payment-note {
            font-size: 9px;
            color: #000000;
            margin-top: 5px;
            text-align: right;
        }

        .status-badge {
            background: #e8f5e9;
            border: 1px solid #c8e6c9;
            padding: 8px 16px;
            display: inline-block;
            font-weight: bold;
            font-size: 11px;
            color: #000000;
            border-radius: 4px;
        }

        /* Payment Details Table */
        .payment-details-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
            margin: 15px 0;
        }

        .payment-details-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #eee;
        }

        .payment-details-table td:first-child {
            width: 200px;
            font-weight: 600;
            background: #f9f9f9;
            color: #555;
        }

        .payment-details-table td:last-child {
            font-weight: 500;
            color: #333;
        }

        .payment-details-table tr:last-child td {
            border-bottom: none;
        }

        /* Signature Section */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0 20px;

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
        }

        .sign-date {
            font-size: 9px;
            color: #000000;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 9px;
            color: #050000;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        /* Page Number */
        .page-number {
            text-align: center;
            font-size: 9px;
            color: #030000;
            margin-top: 20px;
        }

        /* Page 2 Styles */
        .terms-list {
            margin: 15px 0 25px;
            padding-left: 20px;
        }

        .terms-list li {
            margin-bottom: 8px;
            line-height: 1.4;
            font-size: 11px;
        }

        .docs-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .docs-table td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            width: 50%;
            font-size: 11px;
        }

        .cert-badge {
            background: #f5f5f5;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            margin: 20px 0;
            font-size: 11px;
        }

        /* Helper */
        .text-right {
            text-align: right;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        /* Print Optimization */
        @media print {
            body {
                padding: 0;
                margin: 0;
            }

            .status-badge {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    @foreach ($carbooking as $data)
        <div class="invoice">
            <!-- PAGE 1 -->
            <!-- Header -->
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
                            Chandani Chowk, MBBL Collage, Damodarpur, Muzaffarpur,Bihar 843113
                        </div>
                    </td>
                    <td class="invoice-cell">
                        <div class="invoice-title">Booking Slip</div>
                        <div style="width: 100%; text-align: right; margin-top: 10px;">
                            <div
                                style="display: inline-block; border: 1.5px solid #000; padding: 10px 12px; border-radius: 6px; text-align: center; background-color: #fff;">
                                <div>
                                    {!! DNS1D::getBarcodeHTML($data->booking_no, 'C128', 1.2, 40) !!}
                                </div>
                                <div
                                    style="margin-top: 6px; font-size: 12px; font-weight: bold; letter-spacing: 1px;">
                                    {{ $data->booking_no }}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Booking Overview -->
            <div class="section-title">Booking Overview</div>
            <table class="info-table">
                <tr>
                    <td class="label-cell">Booking ID:</td>
                    <td class="value-cell"><strong>{{ $data->booking_no }}</strong></td>
                    <td class="label-cell">Booking Date:</td>
                    <td class="value-cell">{{ date('d-M-Y', strtotime($data->created_at)) }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Branch:</td>
                    <td class="value-cell">{{ $data->branch }}</td>
                    <td class="label-cell">Sales Executive:</td>
                    <td class="value-cell">{{ $data->booking_person }} </td>
                </tr>

            </table>

            <!-- Customer Details -->
            <div class="section-title">Customer Details</div>
            <table class="info-table">
                <tr>
                    <td class="label-cell">Customer Name:</td>
                    <td class="value-cell">{{ strtoupper($data->name) }}</td>
                    <td class="label-cell">Father's Name:</td>
                    <td class="value-cell">{{ strtoupper($data->father) }}</td>
                    <td class="label-cell">Mobile No:</td>
                    <td class="value-cell">{{ $data->mobile }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Aadhar No:</td>
                    <td class="value-cell">{{ $data->aadhar }}</td>
                    <td class="label-cell">PAN No:</td>
                    <td class="value-cell">{{ strtoupper($data->pan) }}</td>
                    <td class="label-cell">City:</td>
                    <td class="value-cell">{{ strtoupper($data->city) }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Address:</td>
                    <td class="value-cell" colspan="5">{{ $data->address }}</td>
                </tr>
            </table>

            <!-- Vehicle Information -->
            <div class="section-title">Vehicle Information</div>
            <table class="vehicle-table">
                <thead>
                    <tr>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Registration No</th>
                        <th>Sell Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ strtoupper($data->carmodel) }}</strong></td>
                        <td>{{ $data->model_year }}</td>
                        <td><strong>{{ strtoupper($data->regnumber) }}</strong></td>

                        <td><strong>₹ {{ $data->total_amount }}/-</strong></td>
                    </tr>
                </tbody>
            </table>

            <!-- Payment Section -->
            {{-- <div class="payment-wrapper">
                <div class="payment-left">
                    <div class="section-title">Payment Breakdown</div>
                    <table class="amount-table">
                        <tr>
                            <td>Vehicle Price (On-Road)</td>
                            <td><strong>₹ {{ $data->total_amount }}/-</strong></td>
                        </tr>
                        <tr>
                            <td>Less: Booking Amount Paid</td>
                            <td><strong>₹ {{ $data->adv_amount }}/-</strong></td>
                        </tr>
                        <tr>
                            <td>Less: Expected Finance Amount</td>
                            <td><strong>₹ {{ $data->finance_amount }}/-</strong></td>
                        </tr>
                        <tr class="total-row">
                            <td><strong>Total Balance Payment</strong></td>
                            <td><strong>₹ {{ $data->due_amount }}/-</strong></td>
                        </tr>
                    </table>
                    <div class="payment-note">
                        *Finance amount indicative, final subject to bank approval
                    </div>
                </div>
                <div class="payment-right">
                    <div class="status-badge">
                        ✓ {{ $booking_status ?? 'Booking Confirmed · Payment Received' }}
                    </div>
                </div>
            </div> --}}
            <table class="payment-wrapper">
                <tr>
                    <td style="width: 60%; vertical-align: top; padding-right: 20px;">
                        <div style="font-weight: bold; margin-bottom: 5px;">Payment Breakdown</div>
                        <table class="amount-table">
                            <tr>
                                <td>Vehicle Price</td>
                                <td style="text-align: right;">Rs. {{ number_format($data->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td>(-) Booking Amount</td>
                                <td style="text-align: right;">Rs. {{ number_format($data->adv_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td>(-) Expected Finance</td>
                                <td style="text-align: right;">Rs. {{ number_format($data->finance_amount, 2) }}</td>
                            </tr>
                            <tr class="total-row">
                                <td>Expected Down Payment</td>
                                <td style="text-align: right;">Rs. {{ number_format($data->due_amount, 2) }}</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 40%; vertical-align: middle;">
                        <div class="status-badge">✓ BOOKING CONFIRMED</div>
                        <div style="font-size: 8px; text-align: left; margin-top: 5px; color: #777;">
                            *Final finance subject to bank approval
                        </div>
                        <div style="margin-top: 10px;">
                            <p>Remarks:</p>
                           <p>{{ $data->remarks }}</p> 
                        </div>
                    </td>
                </tr>
            </table>
            <div class="clearfix"></div>

            <!-- Payment Details -->
            <div class="section-title">Payment Details</div>
            <table class="payment-details-table">
                <tr>
                    <td>Payment Mode:</td>
                    <td>{{ $data->payment_mode }}</td>
                    <td>{{ $data->txn_id ?? 'N/A' }}</td>
                </tr>
            </table>

            <!-- Signature Section -->
            <table class="signature-table">
                <tr>
                    <td>
                        <div>Customer Signature</div>
                        <div class="sign-line"></div>
                        <div class="sign-date">{{ strtoupper($data->name) }} 
                            (Date:{{ date('d-M-Y', strtotime($data->created_at)) }})</div>
                    </td>
                    <td>
                        <div>Authorized Signatory</div>
                        <div class="sign-line"></div>
                        <div class="sign-date">For AMISHEK CAR4SALES TRADING PRIVATE LIMITED</div>
                    </td>
                </tr>
            </table>

            <!-- Footer -->
            <div class="footer">
                {{ $company_email ?? 'support@car4sales.in' }} | {{ $company_phone ?? '+91 777 999 5656' }}
            </div>

            <div class="page-number">
                Page 1 of 2
            </div>

            <!-- PAGE 2 - Terms & Conditions -->
            <div class="page-break"></div>

            <div class="section-title" style="text-align: center; border-left: none; font-size: 16px; margin-top: 0;">
                Terms & Conditions
            </div>

            <ul class="terms-list">
                <li>Booking Amount is non-refundable after 7 days from the date of invoice.</li>
                <li>The file charge for the loan should be paid separately to the financing partner.</li>
                <li>After completing the loan process you will be able to receive your Car/Jeep within stipulated timeline.</li>
                <li>Only available insurance of car will be provided; if non-availability, new comprehensive insurance will be provided by Amishek Car4sales Trading Private Limited for next 1 year.</li>
                <li>Booking cancellation charge is ₹21,000 if cancelled before loan approval. After Loan Approval cancellation charge will be 7% of total Loan Amount.</li>
                <li>Refunds will be processed within 15 business days after deduction of applicable charges.</li>
                
                <li>The vehicle will not be delivered until the full payment (including loan disbursement and down payment) is credited to the company’s account.</li>
                <li>Customers are required to inspect the vehicle thoroughly before delivery; Amishek Car4sales Trading Private Limited shall not be liable for any cosmetic damages reported after the vehicle leaves the premises.</li>
                
                
                <li>All documents provided by the customer for loan processing and registration must be authentic; any legal repercussions due to forged or incorrect documents shall be the sole responsibility of the customer.</li>
                <li>The company reserves the right to cancel the booking if the customer fails to complete the documentation or payment within the agreed timeframe.</li>

                <li>Any modifications to these terms and conditions must be agreed upon in writing by both parties.</li>
                <li>These terms shall be governed by the laws of Muzaffarpur (Bihar) jurisdiction and disputes subject to exclusive jurisdiction of Muzaffarpur courts.</li>
                <li>By availing of our services, you acknowledge that you have read, understood, and agree to these terms and conditions.</li>
            </ul>

            <div class="section-title">Financer Required Documents</div>
            <table class="docs-table">
                <tr>
                    <td>✓ Aadhar Card (Applicant & Co-applicant)</td>
                    <td>✓ PAN Card (Applicant & Co-applicant)</td>
                </tr>
                <tr>
                    <td>✓ Bank Statement (Last 6 Months)</td>
                    <td>✓ Property Tax Receipt / Address Proof</td>
                </tr>
                <tr>
                    <td>✓ Income Tax Returns (Last 2 Years)</td>
                    <td>✓ Salary Slip (4 Months for Salaried)</td>
                </tr>
                <tr>
                    <td>✓ PDC Cheques (6 Qty as per bank)</td>
                    <td>✓ Voter ID / Driving License (Optional)</td>
                </tr>
            </table>

            <div class="cert-badge">
                ✓ Pre-owned car certification verified | 150-point check passed
            </div>

            {{-- <div class="footer" style="margin-top: 20px;">
                This is a computer generated invoice | Valid without signature after booking confirmation
            </div> --}}

             <!-- Signature Section -->
            <table class="signature-table">
                <tr>
                    <td>
                        <div>Customer Signature</div>
                        <div class="sign-line"></div>
                        <div class="sign-date">{{ $data->name ?? 'Customer' }} (Date:
                            {{ $data->created_at ?? 'Date' }})</div>
                    </td>
                    <td>
                        <div>Authorized Signatory</div>
                        <div class="sign-line"></div>
                        <div class="sign-date">For AMISHEK CAR4SALES TRADING PRIVATE LIMITED</div>
                    </td>
                </tr>
            </table>

            <div class="page-number">
                Page 2 of 2
            </div>
        </div>
    @endforeach
</body>

</html>
