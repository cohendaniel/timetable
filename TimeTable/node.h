#pragma once

#include <vector>
#include <memory>

#include "item.h"
#include "block.h"

class Node;
class DupNode;
class ItemNode; 
class BlockNode; 
class SlotNode;

class Node {
	public:
		
		std::vector<std::shared_ptr<Node>> neighbors;
		enum color {white, gray, black};
		enum type {dup, item, block, slot};
		
		Node::Node();
		int ID();
		std::shared_ptr<Node> parent();
		void setParent(std::shared_ptr<Node>);
		Node::color getColor();
		void setColor(color c);
		Node::type getType();
		static void Node::initNodeID();

	protected:
		static int nodeCounter;
		int nID;
		std::shared_ptr<Node> nParent;
		color nColor;
		type nType;
};

class BlockNode : public Node {
	public:
		Block nBlock;
		BlockNode::BlockNode(Block& block);
};

class SlotNode : public Node {
	public:
		SlotNode::SlotNode(std::shared_ptr<BlockNode> blockNode);
	
	private:
		std::shared_ptr<BlockNode> nBlockNode;
};

class ItemNode : public Node {
	public:
		Item nItem;
		ItemNode::ItemNode(Item& item);
		std::vector<std::shared_ptr<BlockNode>> matches;
		std::vector<std::shared_ptr<DupNode>> dups;
};

class DupNode : public Node {
	public:
		DupNode::DupNode(std::shared_ptr<ItemNode> itemNode);
		ItemNode* getItemNode();
	private:
		std::shared_ptr<ItemNode> nItemNode;
};