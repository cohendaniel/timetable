#pragma once

#include <vector>
#include <map>

#include "node.h"
#include "constants.h"

class Graph {
public:	
	std::vector<std::shared_ptr<DupNode>> dupNodes;
	std::vector<std::shared_ptr<ItemNode>> itemNodes;
	std::vector<std::shared_ptr<BlockNode>> blockNodes;
	std::vector<std::shared_ptr<SlotNode>> slotNodes;
	std::shared_ptr<Node> source, sink;

	Graph::Graph(int numNodes);
	void addItem(Item &item);
	void addBlock(Block &block);
	void addEdge(std::shared_ptr<Node> nodeFrom, std::shared_ptr<Node> nodeTo);
	void setEdgeWeight(std::shared_ptr<Node> nodeFrom, std::shared_ptr<Node> nodeTo, int weight);
	int getEdgeWeight(std::shared_ptr<Node> nodeFrom, std::shared_ptr<Node> nodeTo);
	void resetColor();
	int size();
	void Graph::printGraph();

private:
	//note that using this I am assuming that node IDs will be sequential
	// which I think should be fair considering I will be setting them. May not be the most extensible though.
	//std::map<std::pair<Node*, Node*>, int> graph;
	std::vector<std::vector<int>> graph; 
	int numNodes_;

	void addDups(std::shared_ptr<ItemNode> itemNode);
	void addSlots(std::shared_ptr<BlockNode> blockNode);
};