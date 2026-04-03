# People Search Engine

A web-based record management system inspired by public registration systems, designed with a search-engine interface for asynchronous data management.

## 🌟 Overview
The **People Search Engine (PSE)** is a project inspired by public registration systems, designed with an interface that resembles a search engine. Originally developed in 2020 as a study project, it has been completely modernized in 2025/2026 to incorporate modern web standards, focusing on speed, security, and user experience.

> **Project Background & Concept:** [Visit Project Page](https://www.serdaraksakal.com/people-search-engine)

## 🚀 Key Features
- **Asynchronous Operations:** Powered by **AJAX**, allowing users to Create, Read, Update, and Delete records without refreshing the page.
- **Dynamic Search Algorithm:** A highly flexible search engine where partial queries (e.g., searching for "a") return all relevant results from the SQL backend.
- **Automated Media Handling:** Integrated system for uploading and displaying profile photos and digital signatures.
- **Modern UI/UX:** A clean, intuitive interface replacing the old multi-page structure with a streamlined single-page experience.

## 🛠️ Tech Stack
- **Backend:** PHP
- **Frontend:** JavaScript, CSS3, HTML5
- **Database:** MySQL

## 📈 Evolution
| Feature | Legacy Version (2020) | Modernized Engine (2025/2026) |
| :--- | :--- | :--- |
| **Architecture** | Static Multi-Page | **Dynamic Single-Page (AJAX)** |
| **Data Interaction** | Standard HTTP POST | **Real-time Inline Editing** |
| **Database Security** | Basic Queries | **Secure Prepared Statements** |
| **Media Handling** | Manual Directory Management | **Automated Upload & Delete** |
| **UX Consistency** | Resets on every action | **Persistent Scroll & State Control** |

## ⚙️ How to Setup
1. Clone this repository.
2. Import the `pse.sql` file into your MySQL database.
3. Update your database credentials in `db.php`.
4. Ensure the `photo_db/` and `signature_db/` folders have write permissions.
5. Ensure the folder is named `people-search-engine`.
6. Access the project via `localhost/people-search-engine`.

## ⚖️ Legal Disclaimer & Data Privacy
Please ensure full legal compliance before registering any individual using this application. While recording historical figures, managing genealogical data, or utilizing open-source information with explicit permission may be legally permissible, users must always act in accordance with local and international personal data protection regulations.

**The developer of this application assumes no responsibility for the data stored or any legal misuse of the system. All legal liability regarding data privacy and data entry belongs solely to the user.**

## 📜 License
Distributed under the **MIT License**. See `LICENSE` for more information.

## 📬 Contact

**Serdar Aksakal**
* **Website:** [serdaraksakal.com](https://www.serdaraksakal.com)  
* **GitHub:** [@serdar-aksakal](https://github.com/serdar-aksakal)  
* **LinkedIn:** [linkedin.com/in/serdar-aksakal](https://www.linkedin.com/in/serdar-aksakal)
