<x-filament::page>
    <div class="flex w-full">
        {{-- <button id="print-btn">Imprimir Gráfico</button> --}}
        <div id="network-graph" class="flex w-full mx-auto bg-gray-500 rounded-md"></div>
        {{-- <button id="print-btn">Imprimir Gráfico</button> --}}
        <style>
            /* Estilos CSS opcionais para os nós e arestas */
            circle {
                /* fill: rgba(16, 182, 24, 0.897); */
                /* Cor dos nós */
                stroke: rgba(4, 209, 14, 0.897);
                /* Cor da borda dos nós */
                stroke-width: 2px;
                /* Largura da borda dos nós */
            }

            line {
                stroke: rgba(16, 182, 24, 0.473);
                /* Cor das linhas (arestas) */
            }

            text {
                font-size: 12px;
                /* Tamanho do texto dentro dos nós */
                fill: white;
                /* Cor do texto dentro dos nós */
                text-anchor: middle;
                /* Alinha o texto no centro dos nós */
                font-weight: bold;
            }

            #network-graph {
                position: relative;
                width: 100%;
                /* Ajuste a largura conforme necessário */
                height: 600px;
                /* Ajuste a altura conforme necessário */
            }

            #network-graph svg {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                /* Centraliza o SVG em relação ao contêiner */
            }
        </style>
        <script src="https://d3js.org/d3.v7.min.js"></script>
        {{-- <script src="{{ asset('js/d3.min.js') }}"></script> --}}
        <script>
            document.addEventListener('livewire:init', function() {
                const nodes = @json($nodes);
                const links = @json($links);
                const mainNodeId =
                    @json($mainNodeId); // Corrige a passagem da variável


                const width = 800; // Largura do SVG
                const height = 600; // Altura do SVG

                const svg = d3.select("#network-graph")
                    .append("svg")
                    .attr("width", "100%") // Ajusta a largura para 100% do contêiner pai
                    .attr("height", "100%") // Ajusta a altura para 100% do contêiner pai
                    .attr("viewBox", `0 0 ${width} ${height}`) // Ajusta a visualização para o SVG
                    .attr("preserveAspectRatio", "xMidYMid meet"); // Preserva a proporção ao redimensionar



                // Calcula a quantidade total de vínculos para cada nó
                const nodeLinkCounts = nodes.reduce((acc, node) => {
                    acc[node.id] = links.filter(link => link.source === node.id || link.target === node.id)
                        .reduce((sum, link) => sum + link.qtd, 0);
                    return acc;
                }, {});

                const simulation = d3.forceSimulation(nodes)
                    .force("link", d3.forceLink(links)
                        .id(d => d.id)
                        .distance(d => 250 * (1 / d.qtd)) // Ajusta a distância dos links baseado na quantidade
                        .strength(d => d.qtd)) // Força do link
                    .force("charge", d3.forceManyBody().strength(d => -50 - nodeLinkCounts[d.id] * 2))
                    .force("center", d3.forceCenter(width / 2, height / 2))
                    .force("collide", d3.forceCollide().radius(d => 5 + Math.sqrt(nodeLinkCounts[d.id]) * 10));

                const link = svg.append("g")
                    .attr("class", "links")
                    .selectAll("line")
                    .data(links)
                    .enter().append("line")
                    .attr("stroke", "white")
                    .attr("stroke-width", 2);

                const node = svg.append("g")
                    .attr("class", "nodes")
                    .selectAll("circle")
                    .data(nodes)
                    .enter().append("circle")
                    .attr("r", d => 5 + Math.sqrt(nodeLinkCounts[d.id]) * 10)
                    .attr("stroke-width", 2)
                    .attr("fill", d => d.id === mainNodeId ? "blue" :
                        "green") // Cor diferenciada para o nó principal
                    .call(d3.drag()
                        .on("start", dragstarted)
                        .on("drag", dragged)
                        .on("end", dragended));

                // Adiciona título (tooltip) aos nós
                node.append("title")
                    .text(d => d.name);

                // Adiciona texto dentro dos nós
                const labels = svg.append("g")
                    .attr("class", "labels")
                    .selectAll("text")
                    .data(nodes)
                    .enter()
                    .append("text")
                    .attr("dy", ".35em")
                    .attr("x", d => d.x)
                    .attr("y", d => d.y)
                    .text(d => d.name);

                simulation.nodes(nodes)
                    .on("tick", ticked);

                simulation.force("link")
                    .links(links);

                function ticked() {
                    link
                        .attr("x1", d => d.source.x)
                        .attr("y1", d => d.source.y)
                        .attr("x2", d => d.target.x)
                        .attr("y2", d => d.target.y);

                    node
                        .attr("cx", d => d.x)
                        .attr("cy", d => d.y);

                    labels
                        .attr("x", d => d.x)
                        .attr("y", d => d.y);
                }

                function dragstarted(event, d) {
                    if (!event.active) simulation.alphaTarget(0.3).restart();
                    d.fx = d.x;
                    d.fy = d.y;
                }

                function dragged(event, d) {
                    d.fx = event.x;
                    d.fy = event.y;
                }

                function dragended(event, d) {
                    if (!event.active) simulation.alphaTarget(0);
                    d.fx = null;
                    d.fy = null;
                }
            });
            // Adiciona botão de impressão
            document.getElementById('print-btn').addEventListener('click', function() {
                const svgData = document.querySelector("#network-graph svg").outerHTML
                // console.log(svgData)
                const printWindow = window.open('', '', 'height=600,width=800');
                printWindow.document.write(svgData);
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
            });
        </script>
    </div>


</x-filament::page>
