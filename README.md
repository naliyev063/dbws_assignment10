# Assignment 10 — IP Geolocation Map  
**Course:** Databases / Web Systems  
**Student:** Nihat Aliyev  
**Project:** BookReviews Prototype Website  

---

## 📌 Overview
This assignment implements an **IP-based geolocation system** combined with an **interactive map** using Leaflet.js and OpenStreetMap.

The webpage retrieves:
- the visitor’s **public IP address** (as seen by the server),
- the **geolocation data** for that IP (city, region, country, postal code, ISP),
- displays this information in a styled information card (BookVerse design),
- renders a **map centered on the location** using Leaflet,
- and additionally detects the user’s **real device location** (via browser geolocation API) to show accurate physical location such as Bremen.

---

## 🗺 Features
### ✔ Server IP Geolocation  
The server fetches location metadata using:

