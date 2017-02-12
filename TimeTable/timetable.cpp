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

	//char* file1 = "../web/includes/output/output_block.csv";
	//char* file2 = "../web/includes/output/output_item.csv";

	initConstants(std::atoi(argv[3]), std::atoi(argv[4]), std::atoi(argv[5]), std::atoi(argv[6]));
	Graph graph(NUMNODES);
	fillGraph(graph, argv[1], argv[2]);
	//fillGraph(graph, file1, file2);
	makeSchedule(graph);
	findMatches(graph);

	double duration = (std::clock() - start) / (double) CLOCKS_PER_SEC;
	std::cout << "Time: " << duration << std::endl;
}

void initConstants(int d, int i, int b, int s) {
	Node::initNodeID();
	NUMDUPS = d;
	NUMITEMS = i;
	NUMBLOCKS = b;
	NUMSLOTS = s;
	NUMNODES = NUMDUPS + NUMITEMS + NUMBLOCKS + NUMSLOTS + 2;
}

void fillGraph(Graph &g, char* blockFile, char* itemFile) {
	readBlockFile(blockFile, g);
	readItemFile(itemFile, g);
}

void findMatches(Graph &g) {
	std::map<DupNode*, BlockNode*> schedule;
	std::map<BlockNode*, std::vector<DupNode*>> printSchedule;
	for (auto itemNode:g.itemNodes) {
		if (itemNode->matches.size() > 0) {
			for (int matchNum = 0; matchNum < itemNode->matches.size(); matchNum++) {
				schedule[itemNode->dups[matchNum].get()] = itemNode->matches[matchNum].get();
				printSchedule[itemNode->matches[matchNum].get()].push_back(itemNode->dups[matchNum].get()); 
			}
		}
		else {
			std::cout << itemNode->nItem.name << " has not been scheduled." << std::endl;
		}
	}
	for (auto blockNode:g.blockNodes) {
		if (printSchedule.count(blockNode.get()) == 0) {
			std::cout << blockNode->nBlock.name << " block has not been scheduled." << std::endl;
		}
	}
	/*for (std::map<DupNode*, BlockNode*>::iterator it=schedule.begin(); it!=schedule.end(); ++it) {
		if (it->second == NULL) {
			std::cout << it->first->getItemNode()->nItem.name << " has not been scheduled." << std::endl;
		}
		else {
			//std::cout << it->first->getItemNode()->nItem.name << ": " << it->second->nBlock.name << std::endl;
		}
	}*/
	for (std::map<BlockNode*, std::vector<DupNode*>>::iterator it=printSchedule.begin(); it!=printSchedule.end(); ++it) {
		if (it->second.empty()) {
			std::cout << it->first->nBlock.name << " block has not been scheduled." << std::endl;
		}
		else {
			std::cout << it->first->nBlock.name << ",";
			for (auto dup:it->second) {
				std::cout << dup->getItemNode()->nItem.name << ",";
			}
			std::cout << "\n";
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

			std::string itemID, userID, name, numSlots, avail, itemBlock, itemSlot;
			
			std::getline(ss, itemID, ',');
			std::getline(ss, userID, ',');
			std::getline(ss, name, ',');
			std::getline(ss, numSlots, ',');
			std::getline(ss, avail, ',');
			std::getline(ss, itemBlock, ',');
			std::getline(ss, itemSlot, ',');

			Item item(std::stoi(itemID), name, std::stoi(numSlots), avail);
			g.addItem(item);
		}
	}
	else {
		std::cout << "File did not open." << std::endl;
	}
	iFile.close();
}

