{{-- resources/views/catalog.blade.php --}}
@extends('layouts.app')

@section('title', 'Catálogo - OtakuShop')

@section('content')
<!-- Barra superior con filtros principales (móvil y desktop) -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="card-body p-3">
                <div class="row g-2 align-items-center">
                    <!-- Búsqueda -->
                    <div class="col-lg-4 col-md-6">
                        <div class="input-group">
                            <span class="input-group-text" style="border-radius: 15px 0 0 15px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border: none;">
                                <i class="bi bi-search text-white"></i>
                            </span>
                            <input type="text" 
                                   id="searchInput"
                                   class="form-control" 
                                   placeholder="Buscar productos..."
                                   style="border-radius: 0 15px 15px 0; border-left: none;">
                        </div>
                    </div>
                    
                    <!-- Categoría -->
                    <div class="col-lg-2 col-md-6">
                        <select id="categoryFilter" class="form-select" style="border-radius: 15px;">
                            <option value="">📦 Categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Franquicia -->
                    <div class="col-lg-2 col-md-6">
                        <select id="franchiseFilter" class="form-select" style="border-radius: 15px;">
                            <option value="">⭐ Franquicia</option>
                            @foreach($franchises as $franchise)
                                <option value="{{ $franchise->id }}">{{ $franchise->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Ordenar -->
                    <div class="col-lg-2 col-md-6">
                        <select id="sortBy" class="form-select" style="border-radius: 15px;">
                            <option value="created_at">🆕 Recientes</option>
                            <option value="price_asc">💰 Precio ↑</option>
                            <option value="price_desc">💰 Precio ↓</option>
                            <option value="name">🔤 Nombre</option>
                        </select>
                    </div>
                    
                    <!-- Botón Filtros Avanzados -->
                    <div class="col-lg-2 col-md-12">
                        <button class="btn btn-primary-custom w-100" type="button" data-bs-toggle="collapse" data-bs-target="#advancedFilters">
                            <i class="bi bi-sliders"></i> Más Filtros
                        </button>
                    </div>
                </div>

                <!-- Filtros Avanzados Colapsables -->
                <div class="collapse mt-3" id="advancedFilters">
                    <hr>
                    <div class="row g-3">
                        <!-- Precio Mínimo -->
                        <div class="col-md-3 col-6">
                            <label class="form-label small fw-semibold">Precio Mínimo</label>
                            <input type="number" 
                                   id="minPrice"
                                   class="form-control" 
                                   placeholder="0.00€"
                                   min="0"
                                   step="0.01"
                                   style="border-radius: 15px;">
                        </div>
                        
                        <!-- Precio Máximo -->
                        <div class="col-md-3 col-6">
                            <label class="form-label small fw-semibold">Precio Máximo</label>
                            <input type="number" 
                                   id="maxPrice"
                                   class="form-control" 
                                   placeholder="999.99€"
                                   min="0"
                                   step="0.01"
                                   style="border-radius: 15px;">
                        </div>
                        
                        <!-- Disponibilidad -->
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Disponibilidad</label>
                            <select id="availabilityFilter" class="form-select" style="border-radius: 15px;">
                                <option value="">Todos</option>
                                <option value="in_stock">✅ En Stock</option>
                                <option value="preorder">🕐 Preventa</option>
                                <option value="out_of_stock">❌ Agotado</option>
                            </select>
                        </div>
                        
                        <!-- Limpiar Filtros -->
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">&nbsp;</label>
                            <button type="button" id="clearFilters" class="btn btn-outline-secondary w-100" style="border-radius: 15px;">
                                <i class="bi bi-x-circle"></i> Limpiar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Header con resultados y vista -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">
            <i class="bi bi-grid-3x3-gap text-primary"></i> Catálogo
        </h2>
        <p class="text-muted mb-0">
            <span id="totalProducts">{{ $products->total() }}</span> productos encontrados
        </p>
    </div>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-outline-primary active" id="gridView" data-tooltip="Vista Grid">
            <i class="bi bi-grid-3x3"></i>
        </button>
        <button type="button" class="btn btn-outline-primary" id="listView" data-tooltip="Vista Lista">
            <i class="bi bi-list"></i>
        </button>
    </div>
</div>

<!-- Loading Spinner -->
<div id="loadingSpinner" class="text-center py-5" style="display: none;">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Cargando...</span>
    </div>
    <p class="mt-3 text-muted">Buscando productos...</p>
</div>

<!-- Contenedor de Productos -->
<div id="productsContainer" class="row g-4">
    @foreach($products as $product)
    @include('partials.product-card', ['product' => $product])
    @endforeach
</div>

<!-- Mensaje si no hay productos -->
<div id="noProducts" class="text-center py-5" style="display: none;">
    <i class="bi bi-search" style="font-size: 5rem; color: var(--primary-color);"></i>
    <h4 class="mt-3">No se encontraron productos</h4>
    <p class="text-muted">Intenta ajustar los filtros de búsqueda</p>
</div>

<!-- Paginación -->
<div class="mt-5 d-flex justify-content-center" id="paginationContainer">
    @if($products->hasPages())
        <nav>
            <ul class="pagination" id="pagination">
                <!-- La paginación se generará dinámicamente con JS -->
            </ul>
        </nav>
    @endif
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let searchTimeout;
    let currentPage = 1;
    let currentView = 'grid';

    // Elementos del DOM
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const franchiseFilter = document.getElementById('franchiseFilter');
    const minPrice = document.getElementById('minPrice');
    const maxPrice = document.getElementById('maxPrice');
    const availabilityFilter = document.getElementById('availabilityFilter');
    const sortBy = document.getElementById('sortBy');
    const clearFilters = document.getElementById('clearFilters');
    const productsContainer = document.getElementById('productsContainer');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const noProducts = document.getElementById('noProducts');
    const totalProducts = document.getElementById('totalProducts');
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');

    // Búsqueda en tiempo real
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentPage = 1;
            fetchProducts();
        }, 500);
    });

    // Cambios en filtros
    [categoryFilter, franchiseFilter, availabilityFilter, sortBy].forEach(element => {
        element.addEventListener('change', function() {
            currentPage = 1;
            fetchProducts();
        });
    });

    // Filtros de precio
    [minPrice, maxPrice].forEach(element => {
        element.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentPage = 1;
                fetchProducts();
            }, 800);
        });
    });

    // Limpiar filtros
    clearFilters.addEventListener('click', function() {
        searchInput.value = '';
        categoryFilter.value = '';
        franchiseFilter.value = '';
        minPrice.value = '';
        maxPrice.value = '';
        availabilityFilter.value = '';
        sortBy.value = 'created_at';
        currentPage = 1;
        fetchProducts();
        showNotification('Filtros limpiados ✨', 'success');
    });

    // Cambio de vista
    gridView.addEventListener('click', function() {
        currentView = 'grid';
        gridView.classList.add('active');
        listView.classList.remove('active');
        fetchProducts();
    });

    listView.addEventListener('click', function() {
        currentView = 'list';
        listView.classList.add('active');
        gridView.classList.remove('active');
        fetchProducts();
    });

    // Función para obtener productos
    function fetchProducts(page = 1) {
        currentPage = page;
        
        loadingSpinner.style.display = 'block';
        productsContainer.style.opacity = '0.3';
        noProducts.style.display = 'none';

        const params = new URLSearchParams({
            search: searchInput.value,
            category: categoryFilter.value,
            franchise: franchiseFilter.value,
            min_price: minPrice.value,
            max_price: maxPrice.value,
            availability: availabilityFilter.value,
            sort_by: sortBy.value,
            page: page
        });

        fetch(`/api/products/search?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            renderProducts(data.products);
            renderPagination(data.pagination);
            totalProducts.textContent = data.pagination.total;
            
            loadingSpinner.style.display = 'none';
            productsContainer.style.opacity = '1';

            // Scroll suave al inicio
            window.scrollTo({ top: 0, behavior: 'smooth' });
        })
        .catch(error => {
            console.error('Error:', error);
            loadingSpinner.style.display = 'none';
            productsContainer.style.opacity = '1';
            showNotification('Error al cargar productos ❌', 'error');
        });
    }

    // Renderizar productos
    function renderProducts(products) {
        if (products.length === 0) {
            productsContainer.innerHTML = '';
            noProducts.style.display = 'block';
            return;
        }

        noProducts.style.display = 'none';

        const containerClass = currentView === 'grid' ? 'row g-4' : 'list-group';
        productsContainer.className = containerClass;

        productsContainer.innerHTML = products.map(product => {
            if (currentView === 'grid') {
                return renderGridCard(product);
            } else {
                return renderListCard(product);
            }
        }).join('');

        const cards = productsContainer.querySelectorAll('.product-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('fade-in-up');
            }, index * 50);
        });
    }

    // Renderizar card en vista grid
    function renderGridCard(product) {
        const stockBadge = getStockBadge(product);
        
        // Determinar si es URL completa o local
        let imageUrl = '';
        if (product.image) {
            if (product.image.startsWith('http')) {
                imageUrl = product.image; // URL de Cloudinary
            } else {
                imageUrl = `/storage/${product.image}`; // URL local
            }
        }
        
        return `
            <div class="col-md-6 col-lg-4">
                <div class="card product-card h-100">
                    <div class="position-relative overflow-hidden" style="height: 280px;">
                        ${imageUrl ? 
                            `<img src="${imageUrl}" class="product-image" alt="${product.name}">` :
                            `<div class="product-image bg-light d-flex align-items-center justify-content-center">
                                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                            </div>`
                        }
                        ${stockBadge}
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px;">
                                ${product.category.name}
                            </span>
                            <span class="badge bg-light text-dark" style="border-radius: 10px;">
                                ${product.franchise.name}
                            </span>
                        </div>
                        
                        <h6 class="card-title fw-bold mb-2">${product.name}</h6>
                        <p class="text-muted small mb-3 flex-grow-1" style="height: 40px; overflow: hidden;">
                            ${product.description.substring(0, 70)}...
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="h5 mb-0 fw-bold" style="color: var(--primary-color);">
                                ${parseFloat(product.price).toFixed(2)}€
                            </span>
                            <a href="/productos/${product.id}" class="btn btn-sm btn-primary-custom">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Renderizar card en vista lista
    function renderListCard(product) {
        const stockBadge = getStockBadge(product);
        
        // Determinar si es URL completa o local
        let imageUrl = '';
        if (product.image) {
            if (product.image.startsWith('http')) {
                imageUrl = product.image; // URL de Cloudinary
            } else {
                imageUrl = `/storage/${product.image}`; // URL local
            }
        }
        
        return `
            <div class="list-group-item product-card mb-3" style="border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <div class="position-relative" style="height: 120px; overflow: hidden; border-radius: 15px;">
                            ${imageUrl ? 
                                `<img src="${imageUrl}" style="width: 100%; height: 100%; object-fit: cover;" alt="${product.name}">` :
                                `<div class="bg-light d-flex align-items-center justify-content-center h-100">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                </div>`
                            }
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px;">
                                ${product.category.name}
                            </span>
                            <span class="badge bg-light text-dark" style="border-radius: 10px;">
                                ${product.franchise.name}
                            </span>
                            ${stockBadge}
                        </div>
                        <h5 class="fw-bold mb-2">${product.name}</h5>
                        <p class="text-muted mb-0">${product.description.substring(0, 150)}...</p>
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="h4 fw-bold mb-2" style="color: var(--primary-color);">
                            ${parseFloat(product.price).toFixed(2)}€
                        </div>
                        <small class="text-muted">Stock: ${product.stock}</small>
                    </div>
                    <div class="col-md-2 text-center">
                        <a href="/productos/${product.id}" class="btn btn-primary-custom w-100">
                            <i class="bi bi-eye"></i> Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
        `;
    }

    // Obtener badge de stock
    function getStockBadge(product) {
        if (product.is_preorder) {
            return '<span class="product-badge"><i class="bi bi-clock"></i> Preventa</span>';
        } else if (product.stock < 5 && product.stock > 0) {
            return `<span class="product-badge bg-danger">¡Solo ${product.stock}!</span>`;
        } else if (product.stock === 0) {
            return '<span class="product-badge bg-secondary">Agotado</span>';
        }
        return '';
    }

    // Renderizar paginación
    function renderPagination(pagination) {
        const paginationContainer = document.getElementById('pagination');
        if (!paginationContainer) return;

        if (pagination.last_page <= 1) {
            document.getElementById('paginationContainer').style.display = 'none';
            return;
        }

        document.getElementById('paginationContainer').style.display = 'flex';

        let html = '';

        html += `
            <li class="page-item ${pagination.current_page === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${pagination.current_page - 1}">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
        `;

        for (let i = 1; i <= pagination.last_page; i++) {
            if (
                i === 1 || 
                i === pagination.last_page || 
                (i >= pagination.current_page - 2 && i <= pagination.current_page + 2)
            ) {
                html += `
                    <li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `;
            } else if (i === pagination.current_page - 3 || i === pagination.current_page + 3) {
                html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        html += `
            <li class="page-item ${pagination.current_page === pagination.last_page ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${pagination.current_page + 1}">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        `;

        paginationContainer.innerHTML = html;

        paginationContainer.querySelectorAll('a.page-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = parseInt(this.dataset.page);
                if (page && page !== pagination.current_page) {
                    fetchProducts(page);
                }
            });
        });
    }
});
</script>
@endpush