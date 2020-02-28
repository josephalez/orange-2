<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    body {
        margin: 0;
        padding: 0px;
        /* background: red; */
    }
    table, tr , td{
        border:1px solid #000;
        font-size: 13px;
        font-weight:300;
    }
    .logo{
        width: 200px;
        position: absolute;
        left:520px;
        top:4px
    }
    .NV{
        text-align:center;
        width: 50px;
        height: 0px;
    }
    .info-1{
        /* height: 100px; */
    }
    .nb{
        border:none;
    }
    .container{
        margin-left:7.5px
    }
    p, strong{
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif
    }
    .ta{
        text-align: center
    }
    .fs{
        font-size:12px;
    }
    .title{
        padding: 5px;
        font-size:18px
    }
    .title2{
        padding: 3px;
    }
    .mxh{
        height:27px;
        overflow: hidden;
    }
    .mxh2{
        height:50px;
        overflow: hidden;
    }
    .mxh3{
        height:30px;
        overflow: hidden;
    }
    .mxw{
        width: 300px;
    }
    .mxw2{
        width: 70px;
    }
    .pd{
        height:23px;
    }
    .check{
        padding:0px;
        margin: -5px 0 0 0 ;
        text-align:center;
        width: 15px;
        height: 15px;
    }
</style>
<body>
        <img src="../public/imagen/logo.png" class="logo">
<table  width="497px" cellspacing="0"  class="info-sale1">
    <tr>
        <td colspan="6" align="center" class="title">
            <strong>INFORME DE VENTAS</strong>
        </td>
        <td colspan="4" align="center">
            <strong>Numero de venta</strong>
            <p>{{$id}}</p>
        </td>
    </tr>
</table>
<!-- Informe de ventas -->
<table width="100%" cellspacing="0" align="center">
    <tr class="info-1">
        <td colspan="2" align="center">
            <strong>Nombre</strong>
        </td>
        <td colspan="2">
            <p class="container">{{$client_name}}</p>
        </td>
        <td colspan="2" align="center">
            <strong>Rut</strong>
        </td>
        <td colspan="2">
            <p class="container">{{$client_rut}}</p>
        </td>
        <td colspan="3" align="center">
            <strong>Carnet</strong>
        </td>
        <td colspan="1">
            <p class="container">{{$client_carnet}}</p>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <strong>Telefono</strong>
        </td>
        <td colspan="1">
            <p class="container">{{$client_phone}}</p>
        </td>
        <td colspan="3" align="center">
            <strong>Tipo</strong>
        </td>
        <td colspan="2" align="center">
            <p class="container">{{$client_type}}</p>
        </td>
        <td colspan="3" align="center">
            <strong>Clase</strong>
        </td>
        <td colspan="1">
            <p class="container">{{$client_class}}</p>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <strong class="container">E-mail</strong>
        </td>
        <td colspan="2">
            <p class="container">{{$client_email}}</p>
        </td>
        <td colspan="3" align="center">
            <strong class="container">Nacimiento</strong>
        </td>
        <td colspan="1">
            <p class="container mxw2">{{$client_birthday}}</p>
        </td>
        <td colspan="3" align="center">
            <strong class="container">Vencimiento</strong>
        </td>
        <td colspan="1">
            <?php if (isset($client_carnetex)){ ?>
            <p class="container">{{$client_carnetex}}</p>
            <?php }else{ ?>
              <p></p>
            <?php } ?>
        </td>
    </tr>
</table>
<!-- Datos de venta -->
<table width="100%" cellspacing="0" align="center">
    <tr>
        <td colspan="12" align="center" class="container title2">
            <strong>Datos de venta</strong>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <strong class="container">Vendedor</strong>
            <p class="container">{{$seller}}</p>
        </td>
        <td colspan="4">
            <strong class="container">Supervisor</strong>
            <p class="container">{{$supervisor}}</p>
        </td>
        <td colspan="4">
            <strong class="container">Cerrador</strong>
            <p class="container">{{$analyst}}</p>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <strong class="container">Estado</strong>
            <p class="container" style="text-transform: capitalize;">&nbsp;</p>
        </td>
        <td colspan="4">
            <strong class="container">Punto de venta</strong>
            <p class="container">&nbsp;</p>
        </td>
        <td colspan="4">
            <strong class="container">Telefono titular</strong>
            <p class="container">{{$delivery_phone}}</p>
        </td>
    </tr>
</table>
<!-- Datos de equipo -->
<table width="100%" cellspacing="0" align="center" class="fs">
    <tr>
        <td colspan="16" align="center" class="title2">
            <strong>Datos de equipo</strong>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <strong>Tipo</strong>
        </td>
        <td colspan="2" align="center">
            <strong>Base</strong>
        </td>
        <td colspan="2" align="center">
            <strong>PCs a portar</strong>
        </td>
        <td colspan="2" align="center">
            <strong>Plan Contratado</strong>
        </td>
        <td colspan="2" align="center">
            <strong>Equipo</strong>
        </td>
        <td colspan="2" align="center">
            <strong>Plan</strong>
        </td>
        <td colspan="2" align="center">
            <strong>Activacion</strong>
        </td>
        <td colspan="2" align="center">
            <strong>Cuotas</strong>
        </td>
    </tr>
    <?php foreach ($lines as $line) {?>
      <tr>
        <td colspan="2" align="center">
            @switch($line['type'])
                @case($line['type'] = 'nueva_linea')
                    <p class="mxh">Nueva linea</p>
                    @break
                @case($line['type'] = 'portabilidad')
                    <p class="mxh">Portabilidad</p>
                    @break
                @case($line['type'] = 'migracion')
                    <p class="mxh">Migracion</p>
                    @break
                @case($line['type'] = 'bam')
                    <p class="mxh">Bam</p>
                    @break
                @default
                    <p class="mxh">Ninguno</p>
                    @break
            @endswitch
        </td>
        <td colspan="2" align="center">
          <p class="mxh" style="text-transform: capitalize;">{{$line['donor_company']}}</p>
        </td>
        <td colspan="2" align="center">
          <p class="mxh">{{$line['pcs']}}</p>
        </td>
        <td colspan="2" align="center">
          <p class="mxh">{{$line['plan']}}</p>
        </td>
        <td colspan="2" align="center">
          <p class="mxh">{{$line['equipment']}}</p>
        </td>
        <td colspan="2" align="center">
          <p class="mxh">{{$line['plan_cost']}}</p>
        </td>
        <td colspan="2" align="center">
          <p class="mxh">{{$line['price']}}</p>
        </td>
        <td colspan="2" align="center">
          <p class="mxh">{{$line['fees']}}</p>
        </td>
      </tr>
    <?php } ?>

</table>
<!-- Valor numericos -->
<table width="100%" cellspacing="0" align="center">
    <tr>
        <td colspan="12" align="center" class="title2">
            <strong>Valor numericos</strong>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <strong class="container">Chips</strong>
            <p class="ta">{{$chip_price}}</p>
        </td>
        <td colspan="3">
            <strong class="container">Valor del despacho</strong>
            <p class="ta">{{$delivery_price}}</p>
        </td>
        <td colspan="3">
            <strong class="container">Deuda claro</strong>
            <p class="ta">{{$claro_debt}}</p>
        </td>
        <td colspan="3">
            <strong class="container">Pie de convenio</strong>
            <p class="ta">{{$agreement_footer}}</p>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <strong class="container">Valor del kit</strong>
            <p class="ta">&nbsp;</p>
        </td>
        <td colspan="3">
            <strong class="container">Cargo anticipado</strong>
            <p class="ta">{{$advance_charge}}</p>
        </td>
        <td colspan="3">
            <strong class="container">Cargo de activacion</strong>
            <p class="ta">{{$activation_price}}</p>
        </td>
        <td colspan="3">
            <strong class="container">Monto a rendir</strong>
            <p class="ta">{{$total}}</p>
        </td>
    </tr>
</table>
<!-- Datos de despacho -->
<table width="100%" cellspacing="0" align="center">
    <tr>
        <td colspan="12" align="center" class="title2">
            <strong>Datos de despacho</strong>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <strong class="container">Comuna</strong>
        </td>
        <td colspan="3">
            <p class="container">{{$delivery_commune}}</p>
        </td>
        <td colspan="1">
            <strong class="container">Fecha</strong>
        </td>
        <td colspan="2">
            <p class="container">{{$delivery_date}}</p>
        </td>
        <td colspan="2">
            <strong class="container">Hora</strong>
        </td>
        <td colspan="2">
            <p class="container">Desde {{$delivery_initial_time}} hasta {{$delivery_final_time}}</p>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <strong class="container">Direccion despacho</strong>
        </td>
        <td colspan="9">
            <p class="container">{{$delivery_address}}</p>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <strong class="container">Excepcion</strong>
        </td>
        <td colspan="10">
            <?php if ($other_data){ ?>
              <p>
                <?php if ($other_data['excepciones'][0]){ ?>
                  Límite de Endeudamiento
                <?php } ?>

                <?php if ($other_data['excepciones'][1]){ ?>
                  - Deuda Claro
                <?php } ?>

                <?php if ($other_data['excepciones'][2]){ ?>
                  - Meses de Antigüedad (1-6)
                <?php } ?>

                <?php if ($other_data['excepciones'][3]){ ?>
                  - Meses de Antigüedad (1-13)
                <?php } ?>

                <?php if ($other_data['excepciones'][4]){ ?>
                  - Edad
                <?php } ?>

                <?php if ($other_data['excepciones'][5]){ ?>
                  - Cargo Fijo
                <?php } ?>

                <?php if ($other_data['excepciones'][6]){ ?>
                  - Equipo en Arriendo
                <?php } ?>
              </p>
            <?php } ?>
        </td>
    </tr>
</table>
<!-- Datos adicionales -->
<table width="100%" cellspacing="0" align="center">
    <tr>
        <td colspan="10" align="center" class="title2">
            <strong class="container">Datos adicionales</strong>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <strong class="container">Direccion del cliente</strong>
            <p class="container mxh3">{{$client_address}}</p>
        </td>
        <td colspan="6">
            <strong class="container">Observaciones:</strong>
            <p class="container mxh3">{{$observation}}</p>
        </td>
    </tr>
    <tr>
        <td colspan="10">
            <strong class="container">Observaciones del cliente:</strong>
            <p class="container mxh3">{{$delivery_observation}}</p>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <strong class="container">Na Cuenta:</strong>
            <p class="container pd mxw"></p>
        </td>
        <td colspan="2">
            <strong class="container">Na Orden:</strong>
            <p class="container pd mxw"></p>
        </td>
        <td colspan="2">
            <strong class="container">Na Evaluacion</strong>
            <p class="container pd mxw"></p>
        </td>
        <td colspan="2">
            <strong class="container">Na Caso</strong>
            <p class="container pd mxw"></p>
        </td>
        <td colspan="2">
            <p class="container"><strong>Lc:</strong>
                <?php if (isset($other_data['lc'])){ ?>
                    {{$other_data['lc']}}
                <?php } ?>
            </p>
        </td>
    </tr>
</table>
<table cellspacing="1" class="nb">
    <tr>
        <td>
            <div class="check">&nbsp;</div>
        </td>
        <td class="nb">SSTM</td>
        <td>
            <div class="check">&nbsp;</div>
        </td>
        <td class="nb">C.ARR</td>
        <td>
            <div class="check">&nbsp;</div>
        </td>
        <td class="nb">ANEXO E.P</td>
        <td>
            <div class="check">&nbsp;</div>
        </td>
        <td class="nb">EQUIFAX</td>
        <td>
            <div class="check">&nbsp;</div>
        </td>
        <td class="nb">SOLIC.PORT</td>
    </tr>
    <tr>
        <td>
            <div class="check">&nbsp;</div>
        </td>
        <td class="nb">TERM.COND</td>
        <td>
            <div class="check">&nbsp;</div>
        </td>
        <td class="nb">GLOSAS</td>
        <td>
            <div class="check">&nbsp;</div>
        </td>
        <td class="nb">CUPON</td>
        <td>
            <div class="check">&nbsp;</div>
        </td>
        <td class="nb">C.I</td>
    </tr>
</table>
</body>
</html>
