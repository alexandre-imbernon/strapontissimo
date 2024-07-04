$(document).ready(function() {
    $('#searchInput').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'products.php',
                method: 'POST',
                data: { term: request.term },
                dataType: 'json',
                success: function(data) {
                    response(data);
                },
                error: function(xhr, status, error) {
                    console.error('Erreur lors de la requête AJAX:', status, error);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $('#searchInput').val(ui.item.value);
            $('#searchButton').click();
        }
    });
});

$(document).on('click', '.product', function() {
    var url = $(this).data('href');
    window.location.href = url;
});

$(document).ready(function() {
    var productContainer = $('#productContainer');

    function displayProducts(products) {
        productContainer.empty();
        products.forEach(function(product) {
            var productHTML = `
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="product" data-href="details.php?id_product=${product.id_product}">
                        <img src="${product.image}" alt="${product.nom}">
                        <h3>${product.nom}</h3>
                        <div class="overlay">Voir détails</div>
                    </div>
                </div>
            `;
            productContainer.append(productHTML);
        });
    }

    $('#searchInput').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'products.php',
                method: 'POST',
                data: { term: request.term },
                dataType: 'json',
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.nom,
                            value: item.nom
                        };
                    }));
                },
                error: function(xhr, status, error) {
                    console.error('Erreur lors de la requête AJAX:', status, error);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $('#searchInput').val(ui.item.value);
            $('#searchButton').click();
        }
    });

    $('#searchButton').on('click', function() {
        var searchTerm = $('#searchInput').val();
        var category = $('#categorySelect').val();
        var subCategory = $('#subCategorySelect').val();

        $.ajax({
            url: 'products.php',
            method: 'POST',
            data: { 
                term: searchTerm,
                category: category,
                subCategory: subCategory
            },
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    console.error(response.error);
                } else {
                    displayProducts(response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la requête AJAX:', status, error);
            }
        });
    });
});
