username: db104
password: hej123

TODO:
index:
 	länk till Blocked pallets
	länk till Search
	länk till Create new pallets
	barcode-reader-ruta för pallar in till Storage -> bekräfta inläsning
	barcode-reader-ruta för pallar från Storage till delivery -> bekräfta inläsning

Search: (Innehåller inte någon info om BLOCKED products/pallets)
	search for pallet-id
	search for pallets of product
	search for pallets of customer
	Search for orderes that are to be delivired during a spec. time
	search for how many pallets that have been produced during spec. time

Blocked pallets:
  Ingredient
  från och med TID till TID

Create pallets:
  Som movie-booking isch


Diskutera:
  Search by customer doesn't show any info about deliveryDate or things like that


  Pallets.palletId palletId, productionDateTime, state, blocked,
  productName, Orders.orderId orderId, deliveryDateTime, desiredDeliveryDate, customerName ";
  $sql = "SELECT
  Pallets.palletId palletId, productionDateTime, state, blocked,productName, Orders.orderId orderId, deliveryDateTime, desiredDeliveryDate, customerName
  FROM Pallets LEFT OUTER JOIN PalletDeliveries
  ON Pallets.palletId=palletDeliveries.palletId LEFT OUTER JOIN Orders
  ON PalletDeliveries.orderId=Orders.orderId


  //FUNKAR
  select Pallets.palletId palletId, productionDateTime, state, blocked, productName, orderId , deliveryDateTime, desiredDeliveryDate, customerName from Pallets LEFT OUTER JOIN (select palletId, Orders.orderId orderId, deliveryDateTime, desiredDeliveryDate, customerName from PalletDeliveries NATURAL JOIN Orders) InnerQ ON Pallets.palletId=InnerQ.palletId
