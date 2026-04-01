const indicesPorCategoria = {};

function atualizarNumeracaoCategoria(categoriaId) {
    const lista = document.getElementById(`lista-atletas-${categoriaId}`);
    if (!lista) return;

    lista.querySelectorAll(".atleta-item").forEach((item, index) => {
        item.querySelector(".numero-atleta").textContent = index + 1;
    });
}

function atualizarContadorCategoria(categoriaId) {
    const lista = document.getElementById(`lista-atletas-${categoriaId}`);
    const contador = document.getElementById(`contador-${categoriaId}`);

    if (!lista || !contador) return;

    const total = lista.querySelectorAll(".atleta-item").length;
    contador.textContent = `${total} atleta(s)`;
}

function atualizarResumo() {
    const cards = document.querySelectorAll(
        ".card-categoria[data-categoria-id]",
    );
    const resumoCategorias = document.getElementById("resumo-categorias");
    const resumoTotalAtletas = document.getElementById("resumo-total-atletas");

    let totalGeral = 0;
    let html = "";

    cards.forEach((card) => {
        const categoriaId = card.dataset.categoriaId;
        const categoriaNome = card.dataset.categoriaNome;
        const faixaEtaria = card.dataset.faixaEtaria;
        const lista = document.getElementById(`lista-atletas-${categoriaId}`);
        const total = lista ? lista.querySelectorAll(".atleta-item").length : 0;

        if (total > 0) {
            totalGeral += total;
            html += `
                <div class="mb-3">
                    <div class="fw-semibold text-dark">${categoriaNome}</div>
                    <div class="text-muted">${faixaEtaria}</div>
                    <div class="mt-1">
                        <span class="badge bg-dark">${total} atleta(s)</span>
                    </div>
                </div>
            `;
        }
    });

    resumoTotalAtletas.textContent = totalGeral;

    if (html === "") {
        resumoCategorias.innerHTML =
            '<div class="resumo-vazio">Nenhum atleta adicionado ainda.</div>';
    } else {
        resumoCategorias.innerHTML = html;
    }
}

function abrirAccordionDaCategoria(categoriaId) {
    const lista = document.getElementById(`lista-atletas-${categoriaId}`);
    if (!lista) return;

    const collapse = lista.closest(".accordion-collapse");
    if (!collapse) return;

    const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapse, {
        toggle: false,
    });
    bsCollapse.show();
}

function adicionarAtletaNaCategoria(categoriaId, dados = null) {
    if (!indicesPorCategoria[categoriaId]) {
        indicesPorCategoria[categoriaId] = 0;
    }

    const indice = indicesPorCategoria[categoriaId];
    const template = document.getElementById("template-atleta");
    const clone = template.content.cloneNode(true);
    const item = clone.querySelector(".atleta-item");

    const nome = item.querySelector(".campo-nome");
    const data = item.querySelector(".campo-data");
    const sexo = item.querySelector(".campo-sexo");
    const faixa = item.querySelector(".campo-faixa");

    nome.name = `categorias[${categoriaId}][atletas][${indice}][nome_completo]`;
    data.name = `categorias[${categoriaId}][atletas][${indice}][data_nascimento]`;
    sexo.name = `categorias[${categoriaId}][atletas][${indice}][sexo]`;
    faixa.name = `categorias[${categoriaId}][atletas][${indice}][faixa]`;

    if (dados) {
        nome.value = dados.nome_completo || "";
        data.value = dados.data_nascimento || "";
        sexo.value = dados.sexo || "";
        faixa.value = dados.faixa || "";
    }

    item.querySelector(".remover-atleta").addEventListener(
        "click",
        function () {
            item.remove();
            atualizarNumeracaoCategoria(categoriaId);
            atualizarContadorCategoria(categoriaId);
            atualizarResumo();
        },
    );

    document.getElementById(`lista-atletas-${categoriaId}`).appendChild(item);

    indicesPorCategoria[categoriaId]++;
    atualizarNumeracaoCategoria(categoriaId);
    atualizarContadorCategoria(categoriaId);
    atualizarResumo();
    abrirAccordionDaCategoria(categoriaId);
}

function coletarResumoFinal() {
    const cards = document.querySelectorAll(
        ".card-categoria[data-categoria-id]",
    );
    let totalGeral = 0;
    let html = '<div class="text-start">';

    cards.forEach((card) => {
        const categoriaId = card.dataset.categoriaId;
        const categoriaNome = card.dataset.categoriaNome;
        const faixaEtaria = card.dataset.faixaEtaria;
        const lista = document.getElementById(`lista-atletas-${categoriaId}`);
        const total = lista ? lista.querySelectorAll(".atleta-item").length : 0;

        if (total > 0) {
            totalGeral += total;
            html += `
                <div class="mb-3 text-start">
                    <div><strong>${categoriaNome}</strong></div>
                    <div class="text-muted small">${faixaEtaria}</div>
                    <div class="small">${total} atleta(s)</div>
                </div>
            `;
        }
    });

    html += "</div>";

    return { totalGeral, html };
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".adicionar-atleta").forEach((botao) => {
        botao.addEventListener("click", function () {
            const categoriaId = this.dataset.addAtletaCategoriaId;
            adicionarAtletaNaCategoria(categoriaId);
        });
    });

    const campoTelefone = document.getElementById("telefone");

    if (campoTelefone) {
        campoTelefone.addEventListener("input", function (e) {
            e.target.value = aplicarMascaraTelefone(e.target.value);
        });
    }

    if (window.inscricaoConfig) {
        if (window.inscricaoConfig.categoriasOld) {
            Object.keys(window.inscricaoConfig.categoriasOld).forEach(
                (categoriaId) => {
                    const categoria =
                        window.inscricaoConfig.categoriasOld[categoriaId];
                    const atletas = categoria.atletas || [];

                    atletas.forEach((atleta) => {
                        adicionarAtletaNaCategoria(categoriaId, atleta);
                    });
                },
            );
        }

    } else {
        atualizarResumo();
    }

    const btnRevisar = document.getElementById("btn-revisar-inscricao");

    if (btnRevisar) {
        btnRevisar.addEventListener("click", function () {
            const resumo = coletarResumoFinal();

            if (resumo.totalGeral === 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Nenhum atleta adicionado",
                    text: "Adicione pelo menos um atleta em alguma categoria antes de finalizar.",
                    confirmButtonColor: "#7a0d0d",
                });
                return;
            }

            Swal.fire({
                icon: "question",
                title: "Confirmar inscrição?",
                html: `
                    <p><strong>Total de atletas:</strong> ${resumo.totalGeral}</p>
                    <hr>
                    ${resumo.html}
                `,
                showCancelButton: true,
                confirmButtonText: "Sim, finalizar inscrição",
                cancelButtonText: "Voltar",
                confirmButtonColor: "#7a0d0d",
                cancelButtonColor: "#6c757d",
                width: 700,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("form-inscricao").submit();
                }
            });
        });
    }

    atualizarResumo();
});

function aplicarMascaraTelefone(valor) {
    valor = valor.replace(/\D/g, "");

    if (valor.length > 11) {
        valor = valor.slice(0, 11);
    }

    if (valor.length <= 10) {
        valor = valor.replace(/^(\d{2})(\d)/g, "($1) $2");
        valor = valor.replace(/(\d{4})(\d)/, "$1-$2");
    } else {
        valor = valor.replace(/^(\d{2})(\d)/g, "($1) $2");
        valor = valor.replace(/(\d{5})(\d)/, "$1-$2");
    }

    return valor;
}
