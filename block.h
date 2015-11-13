#pragma once

#include <vector>

class Block {
	public:
		int id;
		std::string name;
		std::string date;
		std::string time;
		int numSlots;

		Block::Block(){}
		Block::Block(int blockID, std::string blockName, std::string blockDate,
				 std::string blockTime, int blockNumSlots);
};

