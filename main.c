#include <stdio.h>
#include "complexe.h"

int main(void) {
    Complexe z1, z2, resultat_somme;
    float mod1, mod2;
    
    printf("... PROGRAMME DE GESTION DES NOMBRES COMPLEXES ....\n\n");
    
    
    printf("Création du premier nombre complexe (z1):\n");
    z1 = creer();
    
    printf("\n");
    
   
    printf("Création du deuxième nombre complexe (z2):\n");
    z2 = creer();
    
    printf("\n");
    
    
    printf("=== AFFICHAGE DES NOMBRES COMPLEXES ===\n");
    printf("z1 = ");
    affiche(z1);
    printf("\n");
    
    printf("z2 = ");
    affiche(z2);
    printf("\n\n");
    

    printf("=== CALCUL DES MODULES ===\n");
    mod1 = module(z1);
    mod2 = module(z2);
    printf("Module de z1 = %.2f\n", mod1);
    printf("Module de z2 = %.2f\n\n", mod2);
    

    printf("=== SOMME DES NOMBRES COMPLEXES ===\n");
    resultat_somme = somme(z1, z2);
    printf("z1 + z2 = ");
    affiche(resultat_somme);
    printf("\n");
    printf("Module de la somme = %.2f\n\n", module(resultat_somme));
    
    printf("=== FIN DU PROGRAMME ===\n");
    
    return 0;
}
