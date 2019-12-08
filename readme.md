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
            - Rimborsato da (ID Utente)
```

Il focus del Workshop sarà solo sull'aggregato dell'ordine.
 
- Events:
    - OrderWasPlaced
    - OrderWasPaid
    - OrderWasShipped
    - OrderWasDelivered
    - OrderWasRefunded

- BC: 
    - Spedizioni non sono più gratuite


Workshop:

I libri ed i customers saranno inseriti tramite dei seeds (potrebbero essere create da un altro servizio e l'order service potrebbe essere un sub per poter ricreare il DB dei libri con i dettagli che gli servono[1]).

I customers saranno in grado di acquistare un libro tramite un REST(ish) API.

Vi saranno due CLI Command che saranno utilizzati per muovere lo stato degli ordini (potrebbe essere una chiamata da fare verso un servizio terzo dopo N giorni[2] o un evento ricevuto da un altro servizio[3]).

IMPORTANTE!

La sequenza degli oridni è importante! Pensate a possibili scenario!

Passo passo: https://github.com/damianopetrungaro/laravelday2019-step

(1)[]
Provate ad integrare tramite un pub/sub l'aggiunta nel database libri e customers.

(2)[]
Provate ad integrare una chiamata API verso un servizio mockato che simula le API di un corriere (UPS/Bartolini) per ottenere lo stato dell'ordine (spedito/consegnato) 

(3)[]
Provate ad integrare tramite un pub/sub la notifica di un pagamento avvenuto
