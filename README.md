# Programme de Gestion des Nombres Complexes

## Description
Ce programme en C permet de gérer les nombres complexes avec les opérations suivantes :
- **Créer** un nombre complexe en saisissant ses parties réelle et imaginaire
- **Additionner** deux nombres complexes
- **Calculer** le module (norme) d'un nombre complexe
- **Afficher** un nombre complexe au format a + bi

## Fichiers
- `complexe.h` : Fichier d'en-tête contenant la structure `Complexe` et les déclarations des fonctions
- `complexe.c` : Implémentation des fonctions de gestion des nombres complexes
- `main.c` : Programme principal avec un menu interactif
- `Makefile` : Fichier de compilation

## Compilation

### Avec make
```bash
make          # Compile le programme
make run      # Compile et exécute le programme
make clean    # Supprime les fichiers générés
make rebuild  # Recompile depuis le début
```

### Sans make (GCC)
```bash
gcc -Wall -Wextra -std=c99 -lm -o complexes main.c complexe.c
```

## Exécution
```bash
./complexes    # Sur Linux/Mac
complexes.exe  # Sur Windows (après compilation)
```

## Utilisation
Le programme vous demande de saisir :
1. Les parties réelle et imaginaire du premier nombre complexe (z1)
2. Les parties réelle et imaginaire du deuxième nombre complexe (z2)

Il affiche ensuite :
- Les deux nombres complexes saisis
- Le module de chaque nombre complexe
- La somme de z1 et z2
- Le module de la somme

## Exemple d'exécution
```
=== PROGRAMME DE GESTION DES NOMBRES COMPLEXES ===

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
