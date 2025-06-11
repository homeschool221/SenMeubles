# SenMeubles – Site e-commerce de vente de meubles

## Description
Site e-commerce complet permettant de vendre des meubles avec gestion des produits, utilisateurs (admin/client), commandes et panier. Développé en PHP procédural avec base de données MySQL et interface simple basée sur Bootstrap.

## Fonctionnalités principales

- Affichage des produits
- Gestion du panier et commandes
- CRUD complet sur les produits (interface admin)
- Authentification (inscription/connexion)
- Gestion utilisateurs (admin/client)
- Interface d'administration

## Structure du projet

```
senmeubles/
│
├── config.php               # Connexion à la base de données
├── header.php               # Navbar Bootstrap
├── footer.php               # Pied de page
├── index.php                # Page d'accueil
├── boutique.php             # Liste des meubles
├── panier.php               # Page du panier
├── commander.php            # Formulaire de commande
├── commande_details.php     # Détail d'une commande
├── commandes.php            # Liste des commandes (admin/client)
├── login.php                # Connexion
├── register.php             # Inscription
├── logout.php               # Déconnexion
├── admin/                   # Pages d'administration
│   ├── produits.php         # CRUD produits
│   ├── produit_form.php     # Ajouter/modifier produit
│   ├── supprimer_produit.php# Supprimer produit
│   ├── commandes.php        # Gestion commandes admin
│   └── utilisateurs.php     # Gestion utilisateurs (optionnel)
├── uploads/                 # Images des produits
└── assets/
    ├── css/
    │   └── style.css        # Styles personnalisés
    └── js/
        └── script.js       # JS (optionnel)
```

## Installation

1. **Base de données :**
   - Créez une base `senmeubles` et importez le fichier SQL fourni (`senmeubles.sql`).

2. **Configuration :**
   - Modifiez les infos de connexion dans `config.php`.

3. **Accès admin :**
   - Dans la table `utilisateurs`, créez un utilisateur avec le champ `rôle` à `"admin"`.

4. **Dossier images :**
   - Vérifiez que le dossier `uploads/` est accessible en écriture.

## Dépendances

- [Bootstrap 5](https://getbootstrap.com/)
- PHP ≥ 7.0
- MySQL

---

## Fichiers sources

Chaque page est générée en PHP procédural, code clair et commenté, prêt à l’emploi. Voir ci-dessous.