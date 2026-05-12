#include <stdio.h>

int main() {
    // Denominations des billets et pièces, triées par ordre décroissant
    int denominations[] = {10000, 5000, 2000, 500, 250, 200, 100, 50, 25, 10};
    int num_denominations = 10;

    int amount;
    printf("Entrez la somme d'argent (en unités): ");
    scanf("%d", &amount);

    printf("Décomposition de %d en utilisant un minimum de billets et pièces:\n", amount);

    for(int i = 0; i < num_denominations; i++) {
        int count = amount / denominations[i];
        if(count > 0) {
            printf("%d x %d\n", count, denominations[i]);
            amount %= denominations[i];
        }
    }

    if(amount != 0) {
        printf("Impossible de décomposer complètement la somme restante: %d\n", amount);
    }

    return 0;
}