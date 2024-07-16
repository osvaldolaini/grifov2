<style type="text/css">
    .head {
        font-size: 8pt;
        position: relative;
        text-align: center;
        margin-left: 80px;
        background: #fff;
        width: 500px;
        border: thin solid #f00;
    }

    .ft {
        width: 30%;
    }
</style>

<div class="head"><span style="color:#f00; font:arial bold;">NFORMAÇÃO PESSOAL</span><br />
    <span style="color:#f00;">De acordo com art. 31 da Lei 12.527, de 18 de novembro de 2011 e art 55 do Decreto n°
        7.724, de 16 de maio de 2012.</span>
</div>
<div class="ficha">
    <div style="border: solid 2px #000;width: 100%;">
        <div style="width:100%;float:left; font-size: 10pt;">
            <table width="100%">
                <tr>
                    <td rowspan="5" width="30%">
                        <div style="width:100%;text-align: center;">
                            @if (is_array($record->imagem))
                                <img style="width:60%;" src="{{ url('storage/' . $record->imagem[0]) }}">
                            @endif

                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><b>Nome:</b> {{ $record->nome }}</td>
                </tr>
                <tr>
                    <td><b>Tipo:</b> {{ $record->tipo }}</td>
                    <td><b>CPF:</b> {{ $record->cpf }}</td>
                </tr>
                <tr>
                    <td><b>CodNome / Nome Guerra:</b> {{ $record->codNome }}</td>
                    <td><b>SARAM:</b> {{ $record->saram }}</td>
                </tr>
                <tr>
                    <td colspan="2"><b>Endereços:</b>
                        @if ($record->enderecos)
                            </br>
                            <ul>
                                @foreach ($record->enderecos as $endereco)
                                    <li>
                                        {{ $endereco['address'] }}, {{ $endereco['district'] }},
                                        {{ $endereco['city'] }}-{{ $endereco['state'] }}
                                    </li>
                                @endforeach

                            </ul>
                        @else
                            Nenhum endereço cadastrado
                        @endif

                    </td>
                </tr>
            </table>
        </div>

    </div>
    <div style="width: 100%; border: solid 2px #000; ">
        <div style="max-width: 100%; border-bottom: solid 2px #000;padding:10px;">
            <span style="max-width: 100%;text-align: center;"><strong>Observações</strong></span>
            <div
                style="text-indent: 2em; text-align:justify; width:100%;border-bottom: dashed thin #000;font-size: 10px;">
                <span>{{ $record->obs }}</span>
            </div>
        </div>
    </div>
    <div style="width: 100%; border: solid 2px #000; ">
        @if (!empty($facts))
            <div style="max-width: 100%; border-bottom: solid 2px #000;padding:10px;">
                <span style="max-width: 100%;text-align: center;"><strong>Fatos observados</strong></span>
                @foreach ($facts as $ft)
                    <div style="text-indent: 2em; text-align:justify; max-width:100%;border-bottom: dashed thin #000;">
                        <span>Doc nº {{ $ft->id }} --> {{ $ft->assunto }}</span> </br>
                        <span>{!! $ft->descricao !!}</span>
                    </div>
                @endforeach
            </div>
        @endif
        @if (!empty($docs))
            <div style="max-width: 100%; border-bottom: solid 2px #000;padding:10px;">
                <span style="max-width: 100%;text-align: center;"><strong>Documentos</strong></span>
                @foreach (json_decode($docs) as $resenha)
                    @if ($resenha)
                        <div
                            style="text-indent: 2em; text-align:justify; max-width:100%;border-bottom: dashed thin #000;">
                            <div
                                style="text-indent: 2em; text-align:justify; max-width:100%;border-bottom: dashed thin #000;">
                                <span>Doc nº {{ $resenha->id }} --> {{ $resenha->assunto }}</span> </br>
                                @foreach ($resenha->resenha as $res)
                                    @foreach ($res as $item)
                                        <div style="margin-top: 5px;">
                                            Página: {{ $item->page }}
                                        </div>
                                        <div style="margin-top: 5px;">
                                            Frase encontrada: {{ $item->found_line }}
                                        </div>
                                        <div style="margin-bottom: 5px; border-bottom: solid 1px #000;">
                                            Resumo (255 caracteres): </br> ...{{ $item->following_text }}
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
                {{-- @foreach ($docs as $doc)
                    <div style="max-width:100%;border-bottom: dashed thin #000;">
                        <span>Doc nº {{ $doc->id }} --> {{ $doc->assunto }} </span>
                        @foreach (json_decode($doc->resenha) as $resenha)
                            @if ($resenha)
                                @foreach ($resenha->resenha as $res)
                                    @foreach ($res as $item)
                                        <div>
                                            Página: {{ $item->page }}
                                        </div>
                                        <div>
                                            Resumo (255 caracteres): {{ $item->following_text }}
                                        </div>
                                    @endforeach
                                @endforeach
                            @endif
                        @endforeach

                    </div>
                @endforeach --}}
            </div>
        @endif
    </div>

    <!--TEXTO PADRÃO FECHAMENTO-->
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
                    documento refere-se à Atividade de Inteligência e, como tal, é de utilização interna e considerado
                    preparatório, de acordo com o Decreto nº 7.724, art 3º, inciso XII. A divulgação, a revelação, o
                    fornecimento, a utilização ou a reprodução desautorizada das informações e conhecimentos utilizados,
                    contidos ou veiculados neste documento, a qualquer tempo, meio ou modo, inclusive mediante acesso ou
                    facilitação de acesso indevidos, caracterizam crime de violação do sigilo funcional e improbidade
                    administrativa tipificados, respectivamente, nos art. 154 e art. 325 do Decreto-Lei nº 2.848, e nos
                    art. 116, inciso VIII e art. 132, incisos IV e IX, da Lei nº 8.112/1990.</td>
            </tr>
        </table>
    </div>
