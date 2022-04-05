CREATE OR REPLACE PROCEDURE getRecipes(IN tip_ret varchar(25))
BEGIN
	SELECT reteta_id, nume, descriere, categ_id, vegetariana, timp_preparare, portii, autor
	FROM reteta
	WHERE vegetariana = tipret;
END