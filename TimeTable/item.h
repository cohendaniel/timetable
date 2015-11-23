#pragma once

#include <iostream>
#include <string>
#include <vector>

//#include "debug.h"

class Item {
  public:
    int id;
	std::string name;
	int numDups;
	std::vector<int> avail;
	Item::Item();
    Item(int itemID, std::string itemName, int itemNumDups, std::string itemAvail);

};  