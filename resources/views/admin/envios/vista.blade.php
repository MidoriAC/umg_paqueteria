<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 2</title>
    <link rel="stylesheet" href="style.css" media="all" />
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
        color: #0087C3;
        text-decoration: none;
        }

        body {
        position: relative;
        height: 29.7cm; 
        margin: 0 auto; 
        color: #555555;
        background: #FFFFFF; 
        font-family: Arial, sans-serif; 
        font-size: 14px; 
        font-family: SourceSansPro;
        }

        header {
        padding: 10px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #AAAAAA;
        }

        #company {
        float: right;
        text-align: right;
        }


        #details {
        margin-bottom: 50px;
        }

        #client {
        padding-left: 6px;
        border-left: 6px solid #1a9bfc;
        float: left;
        }

        #client .to {
        color: #777777;
        }

        h2.name {
        font-size: 1.4em;
        font-weight: normal;
        margin: 0;
        }

        #invoice {
        float: right;
        text-align: right;
        }

        #invoice h1 {
        color: #fc341ad2;
        font-size: 2.4em;
        line-height: 1em;
        font-weight: normal;
        margin: 0  0 10px 0;
        }

        #invoice .date {
        font-size: 1.1em;
        color: #777777;
        }

        table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px;
        }

        table th,
        table td {
        padding: 20px;
        background: #EEEEEE;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;
        }

        table th {
        white-space: nowrap;        
        font-weight: normal;
        }

        table td {
        text-align: right;
        }

        table td h3{
        color: #1a9bfc;
        font-size: 1.2em;
        font-weight: normal;
        margin: 0 0 0.2em 0;
        }

        table .no {
        color: #FFFFFF;
        font-size: 1.6em;
        background: #1a9bfc;
        }

        table .desc {
        text-align: left;
        }

        table .unit {
        background: #DDDDDD;
        }

        table .qty {
        }

        table .total {
        background: #1a9bfc;
        color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total {
        font-size: 1.2em;
        }

        table tbody tr:last-child td {
        border: none;
        }

        table tfoot td {
        padding: 10px 20px;
        background: #FFFFFF;
        border-bottom: none;
        font-size: 1.2em;
        white-space: nowrap; 
        border-top: 1px solid #AAAAAA; 
        }

        table tfoot tr:first-child td {
        border-top: none; 
        }

        table tfoot tr:last-child td {
        color: #1a9bfc;
        font-size: 1.4em;
        border-top: 1px solid #1a9bfc; 

        }

        table tfoot tr td:first-child {
        border: none;
        }

        #thanks{
        font-size: 2em;
        margin-bottom: 50px;
        }

        #notices{
        padding-left: 6px;
        border-left: 6px solid #1a9bfc;  
        }

        #notices .notice {
        font-size: 1.2em;
        }

        footer {
        color: #777777;
        width: 100%;
        height: 30px;
        position: absolute;
        bottom: 0;
        border-top: 1px solid #AAAAAA;
        padding: 8px 0;
        text-align: center;
        }

    </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        User
      </div>
      <div id="company">
        <h2 class="name">SISTEMA PAQUETERÍA</h2>
        <div>455 dirección</div>
        <div>(+51) 888807405</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">EMISOR:</div>
          <h2 class="name">{{$envio->name_emisor}}</h2>
          <div class="address">dpi: {{$envio->dpi_emisor}}</div>
          <hr>
          <div class="to">RECEPTOR:</div>
          <h2 class="name">{{$envio->name_receptor}}</h2>
          <div class="address">dpi: {{$envio->dpi_receptor}}</div>
        </div>
        <div id="invoice">
            @if($envio->fragil != 0)
                <h1>FRAGIL</h1>
            @endif
          <div class="date">Fecha de salida: {{$envio->fecha_salida}}</div>
          <div class="date">Fecha de Entrega: {{$envio->updated_at}}</div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">Codigo</th>
            <th class="unit">Peso</th>
            <th class="unit">Precio</th>
          </tr>
        </thead>
        <tbody> 
            <tr>
                <td  class="no">
                    {{$envio->codigo}}
                </td>
                <td class="unit">
                    {{ number_format($envio->peso, 2) }} Kg
                </td>
                <td class="unit">
                    {{ number_format($envio->precio, 2) }}
                </td>
            </tr> 
            <tr>
                <td colspan="1" style="border-left: #ffffff;border-bottom: #ffffff"></td>
                <td class="unit">Total</td>
                <td class="unit"> {{ number_format($envio->precio, 2) }}</td>
            </tr> 
        </tbody>
      </table>
      <div id="thanks">Thank you!</div>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>