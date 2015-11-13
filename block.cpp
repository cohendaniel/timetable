#include "block.h"

Block::Block(int blockID, std::string blockName, std::string blockDate,
				 std::string blockTime, int blockNumSlots) :
		id(blockID),
		name(blockName),
		date(blockDate),
		time(blockTime),
		numSlots(blockNumSlots)
		{}

