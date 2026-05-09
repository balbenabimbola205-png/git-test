#include "complexe.h"
#include <stdio.h>
#include <math.h>


Complexe creer(void) {
    Complexe c;
    
    printf("Entrez la partie réelle du nombre complexe: ");
    scanf("%f", &c.reel);
    
    printf("Entrez la partie imaginaire du nombre complexe: ");
    scanf("%f", &c.imaginaire);
    
    return c;
}


Complexe somme(Complexe c1, Complexe c2) {
    Complexe resultat;
    
    resultat.reel = c1.reel + c2.reel;
    resultat.imaginaire = c1.imaginaire + c2.imaginaire;
    
    return resultat;
}



float module(Complexe c) {
    return sqrt(c.reel * c.reel + c.imaginaire * c.imaginaire);
}



void affiche(Complexe c) {
    if (c.imaginaire >= 0) {
        printf("%.2f + %.2fi", c.reel, c.imaginaire);
    } else {
        printf("%.2f - %.2fi", c.reel, -c.imaginaire);
    }
}
