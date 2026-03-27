<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .table-container { background: white; padding: 30px; border-radius: 15px; shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container mt-5">   
    <div class="table-container shadow-sm"> </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary fw-bold">Gestion de Stock</h2>
            <button class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Ajouter un Produit
            </button>
        </div>

        <table class="table table-hover border">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Désignation</th>
                    <th>Quantité</th>
                    <th>Prix Unitiare</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Ordinateur HP ProBook</td>
                    <td>15</td>
                    <td>5500.00 DH</td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm text-white">Modifier</button>
                        <button class="btn btn-danger btn-sm">Supprimer</button>
                    </td>
                </tr>
                </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>