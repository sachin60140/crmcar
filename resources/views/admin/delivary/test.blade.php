<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans&subset=devanagari" rel="stylesheet">
    <title>Car4Sales Booking Slip</title>
    <style>
        * {
            font-family: 'Noto Sans', sans-serif;
            font-size: 12px;
        }

        body {
            margin: 0;
            padding: 20px;
            background: #fff;
            color: #333;
        }

        .container {
           
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 150px;
        }

        .header h1 {
            margin: 5px 0;
            font-size: 24px;
            color: #f20000;
            font-weight: 900;
        }

        .header p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        .section-title {
            font-size: 16px;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .signatures div {
            text-align: center;
        }

        .terms, .financier-list {
            margin-bottom: 20px;
        }

        .terms ol {
            padding-left: 20px;
            line-height: 1.5;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
        .page-break {
            page-break-after: always;
        }

        /* Gate pass Start */


    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <img src="{{url('assets/img/logotrans.png')}}" alt="Car4Sales Logo">
            
            <p ><strong style="font-size: 16px;">Chandani Chowk, Near Mahindra & Mahindra Showroom, Near Over Bridge, Muzaffarpur, Bihar, 842003</strong></p>
            <p><strong style="font-size: 16px;">Ph : 777 999 5656</strong></p>
        </div>

        <!-- Booking Info -->
     {{--    <div style="border-style: solid; text-align: center; margin-bottom: 5px;">
            <h2 style="font-size: 15px;">Seller</h2>
        </div> --}}
        <div>
            <table>
                <tr >
                    <th style="text-align: center; font-size: 20px">Seller Information</th>
                </tr>
            </table>
        </div>
        <div>
            <table>
                <tr>
                    <th>Seller Name</th>
                    <td>Amit Kumar</td>
                    <th>Seller Father's Name</th>
                    <td>Ramekbal Prasad</td>
                </tr>
                
                <tr>
                    <th>Address</th>
                    <td colspan="3">Kali Sthan Roan, Near Motijhel, Nagar Thana, Muzaffarpur. Bihar</td>
                </tr>
                <tr>
                    <th>Registration</th>
                    <td>BR28AP4855</td>
                    <th>Car Model</th>
                    <td>Scorpio</td>
                    
                </tr>
                <tr>
                    <th>Model Year</th>
                    <td>2023</td>
                    <th>Colour</th>
                    <td>White</td>
                </tr>
                <tr>
                    
                    <th>Owner Sl No.</th>
                    <td>1</td>
                    <th>Engine No </th>
                    <td>45241</td>
                </tr>
                <tr>
                    <th>Chasis No.</th>
                    <td>65482</td>
                    <th>Sell Amount</th>
                    <td>1250000/-</td>
                    
                    
                </tr>
                <tr>
                    <th>Advance/Boking Amount</th>
                    <td>650000/-</td>
                    <th>Finance Amount</th>
                    <td>650000/-</td>
                </tr>
                <tr>
                    
                    <th>Down Payment</th>
                    <td>650000/-</td>
                    <th>Booking Person</th>
                    <td>Saloni</td>
                </tr>
            </table>
        </div>
        <div>
            <table>
                <tr >
                    <th style="text-align: center; font-size: 20px">Buyer Information</th>
                </tr>
            </table>
        </div>
        <div>
            <table>
                <tr>
                    <th>Buyer Name</th>
                    <td>Laldhari Prasad</td>
                    <th>Father's Name</th>
                    <td>Butani Bhagat</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td colspan="3">Kali Sthan Roan, Near Motijhel, Nagar Thana, Muzaffarpur. Bihar</td>
                </tr>
                <tr>
                    <th>Aadhar No.</th>
                    <td>124574854214</td>
                    <th>Pan Card</th>
                    <td>AGSFR5248F</td>
                </tr>
            </table>
        </div>

        <!-- Terms and Conditions -->
        <div class="terms">
            <h3 class="section-title">Terms & Conditions</h3>
            <ol>
                <li>The responsibility of the RC (Registration Certificate) lies with the DTO office, not the showroom.</li>
                <li>Once the RC (Registration Certificate) is updated online, ensure that the insurance is transferred to your name. Otherwise, the showroom will not be responsible if a claim is denied.</li>
                <li>When purchasing the vehicle, make sure to check the toolbox and stepney, as the showroom will not be responsible for them later.</li>
                <li>After taking delivery of the vehicle, CarforSales will not be responsible for any kind of damages related to the vehicle</li>
                <li>In case of accidental damage, we assure that the apron, pillars, and chassis have not been repaired.</li>
                <li>Any debt or legal claim arising after delivery will be the responsibility of the buyer.</li>
                <li>There is no mention of vehicle return in this agreement. However, if any documents related to the vehicle are found to be incorrect in any way, the vehicle must be returned to Car4Sales.</li>
                <li>The buyer is purchasing the car after being satisfied with the documents and after test-driving the vehicle.</li>
                <li>Terms governed by laws of Muzaffarpur jurisdiction.</li>
            </ol>
        </div>
    
        <!-- Signatures -->
        <div class="signatures">
            <div>
                <p>____________________</p>
                <p>Buyer Sign</p>
            </div>
            <div>
                <p>____________________</p>
                <p>Authorized Sign (Car4Sales)</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for choosing Car4Sales. For any inquiries, contact us at +91 777 999 5656.</p>
        </div>
    </div>
    

</body>

</html>
