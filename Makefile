# Makefile pour le programme de gestion des nombres complexes

CC = gcc
CFLAGS = -Wall -Wextra -std=c99 -lm
TARGET = complexes
OBJECTS = main.o complexe.o

# Cible par défaut
all: $(TARGET)

# Construction de l'exécutable
$(TARGET): $(OBJECTS)
	$(CC) $(CFLAGS) -o $(TARGET) $(OBJECTS)

# Compilation de main.c
main.o: main.c complexe.h
	$(CC) $(CFLAGS) -c main.c

# Compilation de complexe.c
complexe.o: complexe.c complexe.h
	$(CC) $(CFLAGS) -c complexe.c

# Exécution du programme
run: $(TARGET)
	./$(TARGET)

# Nettoyage des fichiers générés
clean:
	rm -f $(OBJECTS) $(TARGET)

# Recompilation complète
rebuild: clean all

.PHONY: all run clean rebuild
