# Book Shop

`Perlopiù` è un sito web nel quale un *cliente* una volta registrato, può acquistare *libri* cartacei da ricevere a casa.
I libri sul sito web sono gestiti da alcuni *utenti* di un team che si occupa appositamente dell'inserimento dei nuovi libri e la rimozione dei libri non più in disponibili.
Una volta che il *cliente* è loggato puó procedere all'acquisto di un librio un *ordine* viene *piazzato* e verrà *pagato*.
Questo *ordine* verrà spedito entro i prossimi 5 giorni lavorativi ed il *cliente* lo riceverà entro 7 giorni dall'acquisto.
 
 ```
    Aggregati:
        - Cliente
            - ID
            - Nome
            - Cognome
            - Email
            - Password
            - Indirizzo spedizione
            - Indirizzo fatturazione
        - Utenti
            - ID
            - Nome
            - Cognome
            - Email
            - Password
        - Libro
            - ID
            - Titolo
            - Autore
            - Anno di rilascio
            - Quantità
            - Prezzo
            - Utente
            - Data di inserimento
        - Ordine
            - ID
            - Libro
                - ID
                - Titolo
                - Autore
                - Prezzo
            - Cliente
                - ID
                - Nome
                - Cognome                
                - Indirizzo spedizione
                - Indirizzo fatturazione
            - Data di creazione
            - Data di pagamento
            - Data di spedizione
            - Data di consegna
            - Data di rimborso
            - Utente (rimbordato effettuato)
                - ID

```

```

    Aggregati nel servizio degli ordini:
         - ID
         - Libro
             - ID
             - Titolo
             - Autore
             - Prezzo
         - Cliente
             - ID
             - Nome
             - Cognome
             - Indirizzo spedizione
             - Indirizzo fatturazione
         - Data di creazione
         - Data di pagamento
         - Data di spedizione
         - Data di consegna
         - Data di rimborso
         - Utente (rimbordato effettuato)
             - ID
```
- Events:
    - BookWasInserted
    - BookWasRemoved
    - OrderWasPlaced
    - OrderWasPaid
    - OrderWasShipped
    - OrderWasDelivered
    - OrderWasRefunded

- BC: 
    - Spedizioni non sono più gratuite
