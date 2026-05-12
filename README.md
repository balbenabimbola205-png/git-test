# Système de Gestion d'Hôtel

Un système complet de gestion d'hôtel écrit en PHP avec MySQL.

## Installation

1. Assurez-vous que XAMPP est installé et que Apache et MySQL sont démarrés.

2. Importez la base de données :
   - Ouvrez phpMyAdmin (http://localhost/phpmyadmin)
   - Créez une nouvelle base de données appelée `hotel_management`
   - Importez le fichier `hotel_management.sql`

3. Placez tous les fichiers PHP dans le répertoire `htdocs` de XAMPP (par exemple, `C:\xampp\htdocs\hotel_management\`).

4. Ouvrez votre navigateur et allez à `http://localhost/hotel_management/index.php`

## Fonctionnalités

- **Tableau de bord** : Vue d'ensemble avec statistiques
- **Gestion des Chambres** : Ajouter, modifier, supprimer des chambres
- **Gestion des Clients** : Ajouter, modifier, supprimer des clients
- **Gestion des Réservations** : Créer et gérer des réservations
- **Gestion des Paiements** : Enregistrer les paiements pour les réservations

## Structure de la Base de Données

- `rooms` : Informations sur les chambres
- `guests` : Informations sur les clients
- `bookings` : Réservations
- `payments` : Paiements associés aux réservations

## Sécurité

Ce système est basique et ne doit pas être utilisé en production sans améliorations de sécurité supplémentaires, telles que :
- Validation des entrées
- Authentification des utilisateurs
- Chiffrement des données sensibles
- Protection contre les injections SQL (bien que PDO soit utilisé, une validation supplémentaire est recommandée)

## Dépannage

- Assurez-vous que les permissions des fichiers sont correctes.
- Vérifiez les logs d'erreur PHP dans `C:\xampp\php\logs\php_error_log`.
- Assurez-vous que MySQL est en cours d'exécution.

Création du premier nombre complexe (z1):
Entrez la partie réelle du nombre complexe: 3
Entrez la partie imaginaire du nombre complexe: 4

Création du deuxième nombre complexe (z2):
Entrez la partie réelle du nombre complexe: 1
Entrez la partie imaginaire du nombre complexe: 2

=== AFFICHAGE DES NOMBRES COMPLEXES ===
z1 = 3.00 + 4.00i
z2 = 1.00 + 2.00i

=== CALCUL DES MODULES ===
Module de z1 = 5.00
Module de z2 = 2.24

=== SOMME DES NOMBRES COMPLEXES ===
z1 + z2 = 4.00 + 6.00i
Module de la somme = 7.21

=== FIN DU PROGRAMME ===
```

## Notes
- Les calculs utilisent des nombres en virgule flottante (`float`)
- La fonction `module` utilise la formule : |z| = √(a² + b²)
- Le `-lm` flag est nécessaire pour linker la bibliothèque mathématique
