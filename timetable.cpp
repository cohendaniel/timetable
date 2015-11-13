// TimeTable.cpp : Defines the entry point for the console application.
//
#include <ctime>
#include <cstdlib>
#include <sstream>
#include <fstream>
#include <iostream>
#include <algorithm>

#include "graph.h"
#include "matcher.h"
#include "constants.h"
#include "timetable.h"

int NUMDUPS, NUMITEMS, NUMBLOCKS, NUMSLOTS, NUMNODES, Node::nodeCounter;

/* Parameters:
 *	0: Name
 *  1: Block File
 *  2: Item File
 */

int main(int argc, char* argv[]) {
	std::clock_t start = std::clock();

	initConstants();
	Graph graph(NUMNODES);
	fillGraph(graph);
	makeSchedule(graph);
	findMatches(graph);

	double duration = (std::clock() - start) / (double) CLOCKS_PER_SEC;
	std::cout << "Time: " << duration << std::endl;
}

void initConstants() {
	Node::initNodeID();
	NUMDUPS = 10;
	NUMITEMS = 9;
	NUMBLOCKS = 3;
	NUMSLOTS = 10;
	NUMNODES = NUMDUPS + NUMITEMS + NUMBLOCKS + NUMSLOTS + 2;
}

void fillGraph(Graph &g) {
	char* itemFile = "ITEM_TEST.csv";
	char* blockFile = "BLOCK_TEST.csv";
	readBlockFile(blockFile, g);
	readItemFile(itemFile, g);
}

void findMatches(Graph &g) {
	std::map<DupNode*, BlockNode*> schedule;
	for (auto itemNode:g.itemNodes) {
		for (int matchNum = 0; matchNum < itemNode->matches.size(); matchNum++) {
			schedule[itemNode->dups[matchNum].get()] = itemNode->matches[matchNum].get();
		}
	}
	for (std::map<DupNode*, BlockNode*>::iterator it=schedule.begin(); it!=schedule.end(); ++it) {
		if (it->second == NULL) {
			std::cout << it->first->getItemNode()->nItem.name << " has not been scheduled." << std::endl;
		}
		else {
			std::cout << it->first->getItemNode()->nItem.name << ": " << it->second->nBlock.name << std::endl;
		}
	}
}

void readBlockFile(char* blockFile, Graph &g) {
	std::fstream bFile(blockFile, std::fstream::in);
	if (bFile.is_open()) {
		std::string line;
		while (getline(bFile, line)) {
			std::stringstream ss(line);

			std::string blockID, blockName, blockDate, blockTime, blockNumSlots;

			std::getline(ss, blockID, ',');
			std::getline(ss, blockName, ',');
			std::getline(ss, blockDate, ',');
			std::getline(ss, blockTime, ',');
			std::getline(ss, blockNumSlots, ',');

			Block block(std::stoi(blockID), blockName, blockDate, blockTime, std::stoi(blockNumSlots));
			g.addBlock(block);
		}
	}
	else {
		std::cout << "File did not open." << std::endl;
	}
	bFile.close();
}

void readItemFile(char* itemFile, Graph &g) {
	std::fstream iFile(itemFile, std::fstream::in);

	if (iFile.is_open()) {
		std::string line;
		while (getline(iFile, line)) {

			std::stringstream ss(line);

			std::string itemID, userID, name, numSlots, avail;
			
			std::getline(ss, itemID, ',');
			std::getline(ss, userID, ',');
			std::getline(ss, name, ',');
			std::getline(ss, numSlots, ',');
			std::getline(ss, avail, ',');
				
			Item item(std::stoi(itemID), name, std::stoi(numSlots), avail);
			g.addItem(item);
		}
	}
	else {
		std::cout << "File did not open." << std::endl;
	}
	iFile.close();
}

