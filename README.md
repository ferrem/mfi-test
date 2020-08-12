# mfi-test
Test technique pour une mission Inside chez MétéoFrance International

## Tâches indispensables
- [ ] Créer une table pour stocker la position de sommets montagneux : nom, latitude, longitude, altitude
- [ ] Créer une API REST pour permettre les opérations CRUD sur la table
- [ ] Permettre à travers l'API de retrouver des sommets dans une zone géographique rectangulaire
- [ ] Documenter l'API
- [ ] Déployer le tout avec Docker et Docker-Compose

## Tâches optionnelles
- [ ] Bloquer les connexions provenant de pays non inscrits en liste blanche, et créer une page d'administration verrouillée par user/mdp permettant de consulter les connexions bloquées
- [ ] Créer une page permettant de visualiser les sommets sur une carte (n'utiliser que des paquets open-source)
- [ ] Proposer un algorithme permettant de détecter les sommets anormaux dans une zone géographique (exemple : un sommet de 5000m d'altitude dans les Pyrénées)
