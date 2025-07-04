# Gestion des Stages

Une application web de gestion des stages avec deux types d'utilisateurs : **Admins** et **Étudiants**.  
Cette plateforme permet la gestion centralisée des offres de stage, des demandes, et de la communication entre les étudiants et les administrateurs.

---

## 🧑‍💼 Types d'utilisateurs

### 1. Admin
- Inscription manuelle (par l’administrateur principal ou via la base de données).
- Création d’offres de stage.
- Acceptation ou refus des demandes de stage envoyées par les étudiants.
- Modification de son profil (y compris l’ajout ou la mise à jour de la photo de profil).
- Réception d’emails envoyés par les étudiants.
- Déconnexion sécurisée.

### 2. Étudiant
- Création de compte avec authentification sécurisée.
- Consultation des offres de stages créées par les admins.
- Envoi de demandes de stage pour les offres disponibles.
- Suivi du statut des demandes (acceptée/refusée).
- Importation de son CV (PDF) et de sa photo de profil.
- Modification des informations de son profil.
- Envoi d’emails à tous les admins.
- Déconnexion sécurisée.

---

## 🔐 Sécurité & Accès
- **Aucune page** de l'application n'est accessible sans connexion.
- Système d’authentification protégé (login obligatoire).
- Les permissions sont gérées en fonction du rôle (admin ou étudiant).

---

## 📦 Fonctionnalités principales

| Fonction                                 | Étudiant | Admin |
|------------------------------------------|:--------:|:-----:|
| Créer un compte / Se connecter           | ✅       | ✅ (manuel) |
| Créer des offres de stage                | ❌       | ✅ |
| Voir les offres de stage                 | ✅       | ✅ |
| Envoyer une demande de stage             | ✅       | ❌ |
| Accepter / Refuser une demande           | ❌       | ✅ |
| Voir le statut d’une demande             | ✅       | ✅ |
| Modifier son profil                      | ✅       | ✅ |
| Ajouter une photo de profil              | ✅       | ✅ |
| Importer un CV                           | ✅       | ❌ |
| Envoyer des emails                       | ✅ (aux admins) | ✅ (réception) |
| Déconnexion                              | ✅       | ✅ |

---

## 🛠️ Technologies utilisées
- **Frontend** :  HTML/CS/js
- **Backend** :  php
- **Base de données** : MySQL


👥 Créateurs du projet:
  .MOHAMMED AMINE HAITI

  .RAYANE ELOUALID

  .ANAS ASsILLA