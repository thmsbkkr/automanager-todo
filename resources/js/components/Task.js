import React, { Component } from 'react'

export default class Task extends Component {
  constructor (props) {
    super (props)
  }


  render() {
    return (
      <li className="list-group-item">
        <div className="d-flex align-items-center justify-content-between">
          <div className="flex-grow-1">
            {this.props.task.body}
          </div>

          <div>
            <input
              type="checkbox"
              checked={this.props.task.completed}
              onChange={this.props.onToggle} />
          </div>
        </div>
      </li>
    )
  }
}
