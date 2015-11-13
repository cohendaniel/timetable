#include <iostream>

#include "item.h"

Item::Item(int itemID, std::string itemName, int itemNumDups, std::string itemAvail) :
	id(itemID),
    name(itemName),
	numDups(itemNumDups)
	{
		for (int i = 0; i < itemAvail.length(); i++) {
			avail.push_back(itemAvail[i]-'0');
		}
	}

Item::Item(){
}