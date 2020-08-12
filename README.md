# mfi-test

## Prérequis

- docker-compose

## Installation

```
git clone https://github.com/ferrem/mfi-test.git
cd mfi-test
docker-compose up
```

Attendre que le terminal affiche `mfi-test_composer_1 exited with code 0/1`

La documentation de l'API est accessible sur `http://localhost:8000/api/doc`

## Tâches réalisées

### Obligatoires

- [X] Modèle et table de base de données pour le stockage de sommets montagneux : nom, latitude, longitude, altitude

- [X] Opérations CRUD sur ladite table via API REST

- [X] Listage des sommets dans une zone géographique rectangulaire (selon la projection de Mercator)

- [X] URL de documentation et de test de l'API

- [X] Déploiement de la pile vie docker-compose

### Optionnelles

- [ ] Filtrage IP par liste blanche sur certains pays, et page d'dministration verrouillé par login/mdp permettant de voir les tentatives de connexion

- [ ] Page de visualisation des sommets sur carte (outils open-source uniquement)

- [ ] Algorithme de détection des sommets anormaux dans une zone géographique donnée
