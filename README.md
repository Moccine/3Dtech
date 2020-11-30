### Why ?
---
Basic Symfony setup for Kernix project.
Actually based on Symfony 5.0.X

### Requirements
---
* Apache 2.4
* PHP 7.4 + extension APCu
* Mysql 5.7
* Yarn 1.21+
* Composer 1.10+
* Docker/Docker Compose

### Usage
---
http://localhost:8000 for Symfony
http://localhost:8001 for phpMyAdmin

For Devs you can use the following command when you need to make basic Sf build 
```
make build-dev
```
Dont hesitate to modify MakeFile file and add command like doctrine:migrations 
to it.

### Installation
---

```
make install
```

### Configuration
---

### Troubleshooting
---

### FAQ
---

### Deployment
---
Adapt bin/deploy.sh script to your needs
```
make deploy
```

### Documentation
---

### Authors / Maintainers
---

- Sofiane Souidi
- Jérôme Drzewinski
- Bruno Teboul
- Kaba Condé
