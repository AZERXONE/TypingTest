# TypingTest 👨‍💻

## Egy lokális MYSQL adatbázis alapú internet gyorsteszt PHP és az alap (HTML, CSS, JS) webnyelvek használatával.

## A program részei

- Regisztrációs panel
- Belépés panel
- Internet gyorsteszt panel

A felhasználónevek és emailcímek mind egyediek, ezen tulajdonság segíti a programot abban, hogy nem akadnak össze a felhasználói fiókok az adatbázisban.
Egy felhasználó az alábbiak alapján van regisztráltatva:

- Felhasználónév
- Jelszó
- Email

Fontos megemlíteni, hogy a jelszavak egy úgynevezett Bycrypt algoritmussal kódólva vannak a felhasználói fiókok biztonsága érdekébe.

A bejelentkezés az alábbi információk alapján történik:

- Felhasználónév
- Jelszó

## Internet Gyorsteszt panel

A felhasználó legelősször egy navigációs résszel fog találkozni amivel könnyedén elnavigálhat az oldal különböző részeire.

### Gépelés rész

Maga a typing részre a felhasználó 30 másodpercel rendelkezik. Ha kifut az időből vagy begépelte az idézetet teljesen utána az oldal frissül és kiértékelődik a gépelés. Amennyiben a felhasználó frissítette az oldalt gépelés közben a stopper visszaáll és a kiértékelődés elveszik.

### Statisztika rész

A felhasználó nyomontudja követni fiókjának létrejöttének idejét és korábbi gépelési statisztikáit is itt tudja megnézni.
Ezek a következők:

- Befejezett gépelések száma
- Legjobb WPM
- Legjobb Accuracy
- Átlag WPM
- Legjobb Accuracy

### Ranglista rész

A felhasználóknak lehetőségük van felvenni a versenyt egymás ellen a TOP 10-es palettáért. A ranglista a legjobb 10 legjobb WPM alapján válogat
