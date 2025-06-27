# ✈️ TP BDD : Conception d'une API de gestion d'un aéroport
## 27/06/2025
GUERIT Eloïs <br>
FLEURENT-MERAD Titouan <br>
ABOUZI Robert <br>
PIRES DA CUNHA Mathis
---

API de gestion de vols développée en Symfony, avec deux types d’utilisateurs : `Client` et `Gérant`.  
Les fonctionnalités incluent la recherche de vols directs ou avec escales, la réservation de billets, et quelques autres fonctionnalités de gestion pour les gérants.

---

## 📦 Contenu du projet

- API REST Symfony 7.3 (PHP 8.2+)
- Authentification via JWT (LexikJWTAuthenticationBundle)
- Documentation interactive (NelmioApiDocBundle + OpenAPI)
- Base de données PostgreSQL
- Docker avec multi-containers
- Tests unitaires et fonctionnels (PHPUnit)

---

## 🐳 Lancement avec Docker

### 🔧 Prérequis

- Docker & Docker Compose installés

### 🚀 Démarrage

1. **Cloner le projet :**
   ```bash
   git clone https://github.com/Elo-Get/airport-databse.git
   cd airport-database
   ```
2. **Lancer les containers Docker :**
   ```bash
   docker compose up --build -d
   ```

3. **Installer les dépendances (dans le container `php`) :**
   ```bash
   docker exec -it symfony_tp_php bash
   composer install
   ```

4. **Lancer les migrations & fixtures :**
   ```bash
   php bin/console doctrine:migrations:migrate
   php bin/console doctrine:fixtures:load
   ```

5. **Accéder à l’API :**

   - API: [http://localhost:8000/api](http://localhost:8000/api)
   - Doc Swagger : [http://localhost:8000/api/doc](http://localhost:8000/api/doc)

---

## 👥 Utilisateurs & Sécurité

- **Client**
  - Recherche de vols (directs/indirects)
  - Réservation de billets
  - ...

- **Gérant**
  - Visualiser nombre de passagers par vol
  - Accès restreint via firewall + rôles (`ROLE_GERANT`)

> 🔐 Authentification via JWT – inclure le token `Bearer` dans l’en-tête `Authorization`

---

## 📂 Structure du projet

```
.
├── docker/              
├── src/
│   ├── Controller/
│         ├── Api/
│   ├── Service/
│   ├── Entity/
│   ├── Repository/
│   └── ...
├── config/
├── migrations/
├── tests/
└── ...
```

---

## 🧪 Tests

```bash
php bin/phpunit
```

---

## 📝 À venir / TODO

Nous avons prévu de créer un container supplémentaire pour le front-end en utilisant un framwork tel que React, ainsi que d'ajouter des fonctionnalités supplémentaires pour les gérants et clients.

---

## 🛠 Stack technique

- Symfony 6
- PostgreSQL
- Docker
- PHP 8.2
- JWT (Lexik)
- OpenAPI (Nelmio)
- PHPUnit

---

## 🤝 Contribution

Les PR sont bienvenues ! Merci de respecter les conventions de code PSR-12.  
Avant toute PR : tests, linting et validation de la doc.

---

## 📄 Licence

Projet sous licence MIT.

