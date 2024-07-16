<style type="text/css">
    .head {
        font-size: 10pt;
        position: relative;
        text-align: center;
        margin-left: 100px;
        margin-bottom: 10px;
        background: #fff;
        width: 500px;
        border: thin solid #f00;
    }

    .tab {
        letter-spacing: 2.5cm;
        color: #fff;
    }

    .esp {
        word-spacing: 2cm;
    }

    .texto {
        padding-top: 0px;
        margin-top: 0cm;
        text-align: justify;
        text-indent: 1.5cm;
    }
</style>
<div class="pdf">
    <div class="head"><span style="color:#f00; font:arial bold;">DOCUMENTO PREPARATÓRIO - ACESSO RESTRITO</span><br />
        <span style="color:#f00;">Art. 3°, Inciso XII e Art. 20 do Decreto n° 7.724, de 16 de maio de 2012</span>
    </div>
    <div class="div_mestre">
        <div>
            <table style="text-align:center; width:100%; border:thin solid;">
                <tr>
                    <td>{{ $config->om }}</td>
                </tr>
                <tr>
                    <td>{{ $config->secao }}</td>
                </tr>
                <!--<tr><td ><u>SUBSEÇÃO DE ANÁLISE DE INTELIGÊNCIA</u></td></tr>-->
                <tr>
                    <td height="60px"><B>REGISTRO DE DADOS</B></td>
                </tr>
            </table>
        </div>
        <div>
            <table align="left">
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><b>1.Número de controle: </b>{{ $record->id }}</td>
                </tr>
                <tr>
                    <td><b>2.Envolvidos: </b>
                        @if ($record->vinculos)
                            @php
                                $participantes = $record->vinculos;
                                $participante = '';
                                foreach ($participantes as $key => $value) {
                                    $participante .= '(' . $value . ') ';
                                }
                            @endphp
                        @else
                            @php $participante = ''; @endphp
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><b>3.Data: </b><?php echo date('d/m/Y', strtotime($record->data)); ?></td>
                </tr>
                <tr>
                    <td><b>4.Assunto: </b><?php echo $record->assunto; ?></td>
                </tr>
                <tr>
                    <td><b>5.Fato observado: </b></td>
                </tr>
            </table>
        </div>
        <div class="texto ident" style="border:thin solid;padding:10px;">
            {!! $record->descricao !!}
        </div>
        <div>
            <table style="margin-top:10px;">
                <tr>
                    <td>
                        <center>*_*_*
                    </td>
                </tr>
                <tr>
                    <td>
                        <center><b>ATENÇÃO</b>
                    </td>
                </tr>
                <tr>
                    <td align="justify" style="border: solid #f00; font-size:9pt; color:#f00; position:relative;">Este
                        documento refere-se à Atividade de Inteligência e, como tal, é de utilização interna e
                        considerado preparatório, de acordo com o Decreto nº 7.724, art 3º, inciso XII. A divulgação, a
                        revelação, o fornecimento, a utilização ou a reprodução desautorizada das informações e
                        conhecimentos utilizados, contidos ou veiculados neste documento, a qualquer tempo, meio ou
                        modo, inclusive mediante acesso ou facilitação de acesso indevidos, caracterizam crime de
                        violação do sigilo funcional e improbidade administrativa tipificados, respectivamente, nos art.
                        154 e art. 325 do Decreto-Lei nº 2.848, e nos art. 116, inciso VIII e art. 132, incisos IV e IX,
                        da Lei nº 8.112/1990.</td>
                </tr>
            </table>
        </div>
    </div>
